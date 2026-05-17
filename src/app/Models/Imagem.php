<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Imagem extends Model
{
    protected $fillable = [

        'nome',
        'caminho'
    ];
    public function pessoas()
    {
        return $this->belongsToMany(Pessoa::class);
    }

    public function filmes()
    {
        return $this->belongsToMany(Filme::class);
    }
    public function estudios()
    {
        return $this->belongsToMany(Estudio::class);
    }
}
