<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Pessoa extends Model
{   //esses campos podem ser alterados no banco
    protected $fillable = [
        'cpf',
        'nome',
        'data_nascimento',
        'biografia',
        'genero',
        'nacionalidade'
    ];
    public function ator()
    {
        return $this->hasOne(Ator::class);
    }
    public function diretor()
    {
        return $this->hasOne(Diretor::class);
    }
    public function produtor()
    {
        return $this->hasOne(Produtor::class);
    }
    public function escritor()
    {
        return $this->hasOne(Escritor::class);
    }
    public function imagens()
    {
       return $this->belongsToMany(
        Imagem::class,
        'imagem_pessoa'
    )
    ->withPivot('poster')
    ->withTimestamps();
    }
}
