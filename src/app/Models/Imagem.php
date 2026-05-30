<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Imagem extends Model
{
    protected $table = 'imagens';
    protected $fillable = [

        'nome',
        'caminho'
    ];
    public function pessoas()
    {
        return $this->belongsToMany(
        Pessoa::class,
        'imagem_pessoa'
    )
    ->withPivot('poster')
    ->withTimestamps();
    }

    public function filmes()
    {
        return $this->belongsToMany(\App\Models\Filme::class, 'imagem_filme')
            ->withPivot('poster')
            ->withTimestamps();
    }
    public function estudios()
    {
        return $this->belongsToMany(
            Estudio::class,
            'imagem_estudio'
        )->withPivot('poster')
            ->withTimestamps();
    }

}
