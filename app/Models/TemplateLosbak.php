<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TemplateLosbak extends Model
{
    protected $table = 'template_losbak';
    protected $primaryKey = 'id_template';

    protected $fillable = ['nama_template', 'keterangan'];

    public function details()
    {
        return $this->hasMany(TemplateDetail::class, 'id_template', 'id_template');
    }
}
