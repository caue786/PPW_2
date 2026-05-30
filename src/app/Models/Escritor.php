<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Escritor extends Model
{
   protected $table = 'escritores';

    protected $fillable = [
        'pessoa_id'
    ];

    public function filmes()
    {
        return $this->belongsToMany(Filme::class);
    }

    public function pessoa()
    {
        return $this->belongsTo(Pessoa::class);
    }
}
