<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Curso extends Model
{
    protected $table = 'cursos';

    protected $fillable = ['nombre', 'descripcion'];

    // Un curso tiene muchos estudiantes
    public function estudiantes(): HasMany
    {
        return $this->hasMany(Estudiante::class);
    }
}
