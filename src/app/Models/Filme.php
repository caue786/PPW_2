<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Filme extends Model
{
    protected $fillable = [
        'nome',
        'duracao',
        'data_lancamento',
        'classificacao',
        'sinopse',
        'poster_url'

    ];
    public function atores()
    {
        return $this->belongsToMany(Ator::class)
        ->withPivot('papel');
    }
    public function diretores()
    {
        return $this->belongsToMany(Diretor::class);
    }
    public function produtores()
    {
        return $this->belongsToMany(Produtor::class,'produtor_filme');
    }
    public function escritores()
    {
        return $this->belongsToMany(Escritor::class);
    }

    public function generos()
    {
        return $this->belongsToMany(Genero::class);
    }
    public function estudios()
    {
        return $this->belongsToMany(Estudio::class);
    }
    public function avaliacoes()
    {
        return $this->hasMany(Avaliacao::class);
    }
    public function imagens()
{
    return $this->belongsToMany(\App\Models\Imagem::class, 'imagem_filme')
        ->withPivot('poster')
        ->withTimestamps();
}
}
