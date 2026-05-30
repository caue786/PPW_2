<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Ator extends Model
{
     protected $table = 'atores';

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
