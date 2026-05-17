<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    protected $fillable = [
        'email',
        'nome',
        'senha',
        'admin'
    ];

    public function avaliacoes(){
        return $this->hasMany(Avaliacao::class);
    }
    public function fotoPerfil(){
        return $this-> hasOne(FotoPerfil:: class);
    }
}
