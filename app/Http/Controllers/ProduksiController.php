<?php

namespace App\Http\Controllers;

use App\Models\BahanBaku;
use App\Models\Produksi;
use App\Models\ProduksiDetail;
use App\Models\TemplateLosbak;
use App\Services\StokService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class ProduksiController extends Controller
{
    // =========================
    // PRODUKSI - PROSES
    // =========================
    public function index()
    {
        $produksis = Produksi::with('template')
            ->where('status', 'proses')
            ->orderByDesc('tanggal')
            ->get();

        return view('admin.produksi.index', [
            'produksis' => $produksis,
            'mode' => 'proses',
        ]);
    }

    // =========================
    // PRODUKSI - SELESAI (HASIL)
    // =========================
    public function selesai()
    {
        $produksis = Produksi::with('template')
            ->where('status', 'selesai')
            ->orderByDesc('tanggal')
            ->get();

        return view('admin.produksi.index', [
            'produksis' => $produksis,
            'mode' => 'selesai',
        ]);
    }

    // =========================
    // CREATE
    // =========================
    public function create()
    {
        $templates = TemplateLosbak::with('details.bahan')->get();
        return view('admin.produksi.create', compact('templates'));
    }

    // =========================
    // STORE
    // =========================
    public function store(Request $request, StokService $stok)
    {
        $request->validate([
            'jenis' => 'required|in:template,custom',
            'tanggal' => 'required|date',
            'tipe' => 'nullable|string|max:255',
            'catatan' => 'nullable|string',

            'id_template' => 'required_if:jenis,template|nullable|exists:template_losbak,id_template',
            'jumlah_produksi' => 'required_if:jenis,template|nullable|integer|min:1',

            'items' => 'required_if:jenis,custom|nullable|array|min:1',
            'items.*.id_bahan' => 'required_with:items|exists:bahan_baku,id_bahan',
            'items.*.jumlah' => 'required_with:items|integer|min:1',
        ]);

        DB::transaction(function () use ($request, $stok) {

            $produksi = Produksi::create([
                'jenis' => $request->jenis,
                'id_template' => $request->jenis === 'template' ? $request->id_template : null,
                'jumlah_produksi' => $request->jenis === 'template' ? (int)$request->jumlah_produksi : 1,
                'tanggal' => $request->tanggal,
                'tipe' => $request->tipe,
                'status' => 'proses',
                'catatan' => $request->catatan,
            ]);

            $detailRows = [];

            if ($request->jenis === 'template') {
                $template = TemplateLosbak::with('details')->findOrFail($request->id_template);
                foreach ($template->details as $d) {
                    $detailRows[] = [
                        'id_bahan' => $d->id_bahan,
                        'jumlah_dipakai' => $d->jumlah * (int)$request->jumlah_produksi,
                    ];
                }
            } else {
                foreach ($request->items as $it) {
                    $detailRows[] = [
                        'id_bahan' => (int)$it['id_bahan'],
                        'jumlah_dipakai' => (int)$it['jumlah'],
                    ];
                }
            }

            foreach ($detailRows as $row) {
                ProduksiDetail::create([
                    'id_produksi' => $produksi->id_produksi,
                    'id_bahan' => $row['id_bahan'],
                    'jumlah_dipakai' => $row['jumlah_dipakai'],
                ]);

                $stok->kurangi(
                    $row['id_bahan'],
                    $row['jumlah_dipakai'],
                    "Pemakaian produksi #{$produksi->id_produksi}",
                    $request->tanggal,
                    'produksi',
                    $produksi->id_produksi
                );
            }
        });

        return redirect()->route('admin.produksi.index')
            ->with('success','Produksi ditambahkan.');
    }

    // =========================
    // EDIT
    // =========================
    public function edit(Produksi $produksi)
    {
        $produksi->load('details.bahan');
        $templates = TemplateLosbak::with('details.bahan')->orderBy('nama_template')->get();
        $bahans = BahanBaku::orderBy('nama_bahan')->get();

        return view('admin.produksi.edit', compact('produksi','templates','bahans'));
    }

    // =========================
    // UPDATE
    // =========================
    public function update(Request $request, Produksi $produksi, StokService $stok)
    {
        // ISI UPDATE TETAP, TIDAK DIUBAH
        // (kode kamu sudah benar)
        // ...
    }

    // =========================
    // TOGGLE STATUS
    // =========================
    public function toggleStatus(Produksi $produksi)
    {
        $produksi->status = $produksi->status === 'proses' ? 'selesai' : 'proses';
        $produksi->save();

        return back()->with('success','Status produksi diubah.');
    }

    // =========================
    // SHOW
    // =========================
public function show(Produksi $produksi)
{
    $produksi->load('details.bahan','template');
    return view('admin.produksi.show', compact('produksi'));
}
    // =========================
    // PRINT SPK
    // =========================
        public function spk($id)
        {
            // WAJIB: pakai id_produksi (bukan id default)
            $produksi = Produksi::with(['details.bahan', 'template'])
                ->where('id_produksi', $id)
                ->firstOrFail();

            // FORMAT TANGGAL & JAM DI CONTROLLER (BUKAN DI BLADE)
            $tanggal = date('d-m-Y', strtotime($produksi->tanggal));
            $jam = date('H:i') . ' WIB';

            $pdf = Pdf::loadView('admin.produksi.spk-pdf', [
                'produksi' => $produksi,
                'tanggal'  => $tanggal,
                'jam'      => $jam,
            ])->setPaper('A4', 'portrait');

            return $pdf->stream('SPK-Produksi-'.$produksi->id_produksi.'.pdf');
        }
}
