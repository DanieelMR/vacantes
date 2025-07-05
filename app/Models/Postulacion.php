<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Postulacion extends Model
{
    use HasFactory;

    protected $table = 'postulaciones';

    protected $fillable = [
        'vacante_id',
        'nombre_estudiante',
        'matricula',
        'correo_est',
        'telefono_est',
        'carrera_id',
        'semestre_actual',
        'promedio',
        'mensaje_adicional',
        'estado_postulacion',
        'fecha_postulacion'
    ];

    protected $casts = [
        'promedio' => 'decimal:2',
        'fecha_postulacion' => 'datetime',
    ];

    public function vacante()
    {
        return $this->belongsTo(Vacante::class);
    }

    public function carrera()
    {
        return $this->belongsTo(Carrera::class);
    }

    public function scopePendientes($query)
    {
        return $query->where('estado_postulacion', 'pendiente');
    }

    public function scopeAceptadas($query)
    {
        return $query->where('estado_postulacion', 'aceptada');
    }

    public function getEstadoTextoAttribute()
    {
        return match($this->estado_postulacion) {
            'pendiente' => 'Pendiente',
            'aceptada' => 'Aceptada',
            'rechazada' => 'Rechazada',
            default => 'Sin estado'
        };
    }
}
