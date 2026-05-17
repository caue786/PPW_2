<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FotoPerfil extends Model
{
    protected $fillable = [
        'usuario_id',
        'nome',
        'caminho'
    ];

    public function usuario()
    {
        return $this->belongsTo(Usuario::class);
    }
}
