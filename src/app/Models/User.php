<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable([
    'name',
    'email',
    'password',
    'role'
])]
#[Hidden([
    'password',
    'remember_token'
])]
class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // =========================
    // RELACIONAMENTOS
    // =========================

    public function avaliacoes()
    {
        return $this->hasMany(Avaliacao::class);
    }

    public function fotoPerfil()
    {
        return $this->hasOne(FotoPerfil::class);
    }

    // =========================
    // ROLES
    // =========================

   public function isAdmin(): bool
{
    return $this->role === 'admin';
}

public function isUsuario(): bool
{
    return $this->role === 'user';
}
}