<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Estudio extends Model
{
    protected $fillable = [
        'nome',
        'local'
    ];
    public function filmes()
    {
        return $this->belongsToMany(Filme::class);
    }
    public function imagens()
    {
        return $this->belongsToMany(Imagem::class);
    }
}
