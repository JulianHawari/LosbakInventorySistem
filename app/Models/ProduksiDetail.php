<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProduksiDetail extends Model
{
    protected $table = 'produksi_detail';
    protected $primaryKey = 'id_detail';

    protected $fillable = ['id_produksi','id_bahan','jumlah_dipakai'];

    public function bahan()
    {
        return $this->belongsTo(BahanBaku::class,'id_bahan','id_bahan');
    }
}
