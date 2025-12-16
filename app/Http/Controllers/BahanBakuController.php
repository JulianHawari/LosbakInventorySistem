<?php

namespace App\Http\Controllers;

use App\Models\BahanBaku;
use App\Models\StokLog;
use App\Services\StokService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BahanBakuController extends Controller
{
    public function index()
    {
        $bahans = BahanBaku::orderBy('nama_bahan')->get();

        // Prediksi habis: rata-rata OUT 30 hari
        $prediksi = [];
        $start = Carbon::now()->subDays(30)->toDateString();

        foreach ($bahans as $b) {
            $totalOut = StokLog::where('id_bahan', $b->id_bahan)
                ->where('tipe', 'OUT')
                ->where('tanggal', '>=', $start)
                ->sum('jumlah');

            $avgPerDay = $totalOut / 30;

            if ($avgPerDay > 0) {
                $daysLeft = (int) floor($b->stok / $avgPerDay);
                $prediksi[$b->id_bahan] = [
                    'avg_per_day' => round($avgPerDay, 2),
                    'days_left' => $daysLeft,
                    'estimated_date' => now()->addDays($daysLeft)->toDateString(),
                ];
            } else {
                $prediksi[$b->id_bahan] = null;
            }
        }

        return view('admin.bahan.index', compact('bahans','prediksi'));
    }

    public function create()
    {
        return view('admin.bahan.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_bahan' => 'required|max:255',
            'satuan' => 'required|max:255',
            'stok' => 'nullable|integer|min:0',
        ]);

        DB::transaction(function () use ($validated) {
            $bahan = BahanBaku::create([
                'nama_bahan' => $validated['nama_bahan'],
                'satuan' => $validated['satuan'],
                'stok' => (int)($validated['stok'] ?? 0),
            ]);

            if ($bahan->stok > 0) {
                StokLog::create([
                    'id_bahan' => $bahan->id_bahan,
                    'tipe' => 'IN',
                    'jumlah' => $bahan->stok,
                    'keterangan' => 'Stok awal',
                    'tanggal' => now()->toDateString(),
                    'ref_type' => 'init',
                    'ref_id' => $bahan->id_bahan,
                    'stok_setelah' => $bahan->stok,
                ]);
            }
        });

        return redirect()->route('admin.bahan.index')
            ->with('success','Bahan baku ditambahkan.');
    }

    public function edit(BahanBaku $bahan)
    {
        return view('admin.bahan.edit', compact('bahan'));
    }

    public function update(Request $request, BahanBaku $bahan)
    {
        $validated = $request->validate([
            'nama_bahan' => 'required|max:255',
            'satuan' => 'required|max:255',
        ]);

        $bahan->update($validated);

        return redirect()->route('admin.bahan.index')
            ->with('success','Bahan baku diupdate.');
    }

    public function destroy(BahanBaku $bahan)
    {
        $bahan->delete();
        return back()->with('success','Bahan baku dihapus.');
    }

    // LOG STOK GLOBAL (MASIH DI MENU BAHAN)
    public function logStok()
    {
        $logs = StokLog::with('bahan')
            ->orderByDesc('tanggal')
            ->orderByDesc('id_log')
            ->paginate(25);

        return view('admin.bahan.logstok', compact('logs'));
    }

    public function restockForm(BahanBaku $bahan)
    {
        return view('admin.bahan.restock', compact('bahan'));
    }

    public function restock(Request $request, BahanBaku $bahan, StokService $stok)
    {
        $validated = $request->validate([
            'jumlah' => 'required|integer|min:1',
            'tanggal' => 'required|date',
            'keterangan' => 'nullable|string|max:255',
        ]);

        DB::transaction(function () use ($validated, $bahan, $stok) {
            $stok->tambah(
                $bahan->id_bahan,
                $validated['jumlah'],
                $validated['keterangan'] ?: 'Tambah stok',
                $validated['tanggal'],
                'restock',
                $bahan->id_bahan
            );
        });

        return redirect()->route('admin.bahan.index')
            ->with('success','Stok berhasil ditambah & tercatat.');
    }
        public function clearLogStok()
    {
        // optional: pastikan admin
        // abort_unless(auth()->user()->is_admin, 403);

        StokLog::truncate();

        return redirect()
            ->route('admin.bahan.logstok')
            ->with('success', 'Semua log stok berhasil dihapus.');
    }
}
