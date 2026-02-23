<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    // Apuntar a la tabla 'usuarios' que ya existe en la BD
    protected $table = 'usuarios';

    protected $fillable = ['nombre', 'email', 'password', 'rol'];

    protected $hidden = ['password'];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }

    // Laravel usa el campo 'name' para mostrarlo en vistas por defecto.
    // Creamos un accesor para que devuelva 'nombre'.
    public function getNameAttribute(): string
    {
        return $this->nombre;
    }
}
