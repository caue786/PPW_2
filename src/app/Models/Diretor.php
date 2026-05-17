<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Diretor extends Model
{
     protected $fillable = [
        'pessoa_id'
    ];
    public function filmes(){
        return $this-> belongsToMany(Filme::class);
    }
    public function pessoa(){
        return $this->belongsTo(Pessoa::class);
    }
}

