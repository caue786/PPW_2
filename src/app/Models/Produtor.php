<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Produtor extends Model
{
     protected $table = 'produtores';

    protected $fillable = [
        'pessoa_id'
    ];

    public function filmes()
    {
        return $this->belongsToMany(Filme::class,'produtor_filme');
    }

    public function pessoa()
    {
        return $this->belongsTo(Pessoa::class);
    }
}
