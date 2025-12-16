<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StokLog extends Model
{
    protected $table = 'log_stok';
    protected $primaryKey = 'id_log';

    protected $fillable = [
        'id_bahan',
        'tipe',          // IN / OUT
        'jumlah',
        'keterangan',
        'tanggal',
        'ref_type',
        'ref_id',
        'stok_setelah',
    ];

    public function bahan()
    {
        return $this->belongsTo(BahanBaku::class, 'id_bahan', 'id_bahan');
    }
}
