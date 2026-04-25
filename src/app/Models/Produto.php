<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Produto extends Model
{
    public $timestamps = false;
    //coluns podem ser prenchidas em massa (via crate ou update )
  protected $fillable = [
    'nome',
    'preco'
  ] ; //
}
