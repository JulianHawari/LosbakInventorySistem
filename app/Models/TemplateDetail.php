<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TemplateDetail extends Model
{
    protected $table = 'template_detail';
    protected $primaryKey = 'id_detail';
    public $timestamps = true;

    protected $fillable = ['id_template', 'id_bahan', 'jumlah'];

    public function bahan()
    {
        return $this->belongsTo(BahanBaku::class, 'id_bahan', 'id_bahan');
    }
}

