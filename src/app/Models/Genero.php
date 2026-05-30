<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Genero extends Model
{
     protected $fillable = [
        'nome',
        'imagem'
    ];
    public function filmes(){
    return $this->belongsToMany(Filme::class);
    }
}
