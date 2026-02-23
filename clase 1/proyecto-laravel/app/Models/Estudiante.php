<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Estudiante extends Model
{
    // Tabla en la base de datos
    protected $table = 'estudiantes';

    // Campos que se pueden asignar en masa (create / update)
    protected $fillable = [
        'nombre',
        'apellido',
        'dni',
        'email',
        'telefono',
        'fecha_nac',
        'curso_id',
        'estado',
    ];

    // Casteos de tipos automáticos
    protected $casts = [
        'fecha_nac' => 'date',
    ];

    // ── Relación ────────────────────────────────────────────
    // Un estudiante pertenece a un curso
    public function curso(): BelongsTo
    {
        return $this->belongsTo(Curso::class);
    }

    // ── Accesor de nombre completo ───────────────────────────
    public function getNombreCompletoAttribute(): string
    {
        return "{$this->apellido}, {$this->nombre}";
    }
}
