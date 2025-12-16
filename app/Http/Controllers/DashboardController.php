<?php

namespace App\Http\Controllers;

use App\Models\Produksi;
use App\Models\BahanBaku;
use App\Models\TemplateLosbak;

class DashboardController extends Controller
{
    public function index()
    {
    // notif stok menipis
    $stokMenipis = BahanBaku::whereColumn('stok', '<=', 'min_stok')->get();

        $totalProduksi   = Produksi::count();
        $produksiAktif   = Produksi::where('status', 'proses')->count();
        $jumlahBahan     = BahanBaku::count();
        $jumlahTemplate  = TemplateLosbak::count();

        $produksiTerakhir = Produksi::with('template')
            ->orderByDesc('tanggal')
            ->limit(5)
            ->get();

        $bahanHampirHabis = BahanBaku::where('stok', '<=', 10)->get();

        return view('admin.dashboard', compact(
            'totalProduksi',
            'produksiAktif',
            'jumlahBahan',
            'jumlahTemplate',
            'produksiTerakhir',
            'bahanHampirHabis',
            'stokMenipis'
        ));
    }
}
