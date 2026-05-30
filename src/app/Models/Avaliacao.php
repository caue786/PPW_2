<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Avaliacao extends Model
{
     protected $table = 'avaliacoes';
   protected $fillable = [
        'nota',
        'descricao',
        'filme_id',
        'usuario_id'
    ];

    public function usuario(){
        return $this->belongsTo(Usuario::class);
    }
    public function filme(){
        return $this->belongsTo(Filme::class);
    }
}
