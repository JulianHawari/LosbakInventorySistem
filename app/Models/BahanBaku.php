<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BahanBaku extends Model
{
    protected $table = 'bahan_baku';
    protected $primaryKey = 'id_bahan';

    protected $fillable = [
    'nama_bahan',
    'satuan',
    'stok',
    'min_stok',
        ];


    public function logs()
    {
        return $this->hasMany(LogStok::class, 'id_bahan', 'id_bahan');
    }
}
