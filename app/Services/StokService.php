<?php

namespace App\Services;

use App\Models\BahanBaku;
use App\Models\StokLog;
use App\Mail\StokMenipisMail;
use Illuminate\Support\Facades\Mail;

class StokService
{
    public function tambah(
        int $idBahan,
        int $qty,
        string $ket,
        string $tanggal,
        ?string $refType = null,
        ?int $refId = null
    ): void {
        $bahan = BahanBaku::lockForUpdate()->findOrFail($idBahan);

        $bahan->stok += $qty;
        $bahan->save();

        StokLog::create([
            'id_bahan' => $idBahan,
            'tipe' => 'IN',
            'jumlah' => $qty,
            'keterangan' => $ket,
            'tanggal' => $tanggal,
            'ref_type' => $refType,
            'ref_id' => $refId,
            'stok_setelah' => $bahan->stok,
        ]);
    }

    public function kurangi(
    int $idBahan,
    int $qty,
    string $ket,
    string $tanggal,
    ?string $refType = null,
    ?int $refId = null
): array {
    $bahan = BahanBaku::lockForUpdate()->findOrFail($idBahan);

    $stokSebelum = $bahan->stok;

    if ($stokSebelum < $qty) {
        return [
            'success' => false,
            'message' => "Stok {$bahan->nama_bahan} tidak cukup."
        ];
    }

    $bahan->stok -= $qty;
    $bahan->save();

    StokLog::create([
        'id_bahan' => $idBahan,
        'tipe' => 'OUT',
        'jumlah' => $qty,
        'keterangan' => $ket,
        'tanggal' => $tanggal,
        'ref_type' => $refType,
        'ref_id' => $refId,
        'stok_setelah' => $bahan->stok,
    ]);

    if (
        $stokSebelum > $bahan->min_stok &&
        $bahan->stok <= $bahan->min_stok
    ) {
        Mail::to(env('ADMIN_EMAIL'))
            ->send(new StokMenipisMail($bahan));

    }

    return [
        'success' => true
    ];
}
}
