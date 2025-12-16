<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Produksi extends Model
{
    protected $table = 'produksi';
    protected $primaryKey = 'id_produksi';

    protected $fillable = [
        'jenis','id_template','jumlah_produksi','tanggal','tipe','status','catatan'
    ];

    public function template()
    {
        return $this->belongsTo(TemplateLosbak::class, 'id_template', 'id_template');
    }

    public function details()
    {
        return $this->hasMany(ProduksiDetail::class, 'id_produksi', 'id_produksi');
    }
}

