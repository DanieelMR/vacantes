<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Vacante extends Model
{
    use HasFactory;

    protected $fillable = [
        'titulo',
        'descripcion',
        'tipo',
        'empresa_id',
        'carreras_dirigidas',
        'estado',
        'requisitos',
        'modalidad',
        'duracion_meses',
        'con_beca',
        'monto_beca',
        'fecha_inicio',
        'fecha_limite_postulacion',
        'num_plazas',
        'observaciones_admin',
        'fecha_aprobacion',
        'aprobado_por'
    ];

    protected $casts = [
        'carreras_dirigidas' => 'array',
        'con_beca' => 'boolean',
        'monto_beca' => 'decimal:2',
        'duracion_meses' => 'decimal:1',
        'fecha_inicio' => 'date',
        'fecha_limite_postulacion' => 'date',
        'fecha_aprobacion' => 'datetime',
    ];

    public function empresa()
    {
        return $this->belongsTo(Empresa::class);
    }

    public function postulaciones()
    {
        return $this->hasMany(Postulacion::class);
    }

    public function aprobadoPor()
    {
        return $this->belongsTo(Usuario::class, 'aprobado_por');
    }

    public function getCarrerasAttribute()
    {
        if (!$this->carreras_dirigidas) {
            return collect();
        }
        
        // Asegurar que sea array
        $carreras = is_string($this->carreras_dirigidas) ? 
            json_decode($this->carreras_dirigidas, true) : 
            $this->carreras_dirigidas;
            
        if (!is_array($carreras) || empty($carreras)) {
            return collect();
        }
        
        return Carrera::whereIn('clave', $carreras)->get();
    }

    public function scopePublicadas($query)
    {
        return $query->where('estado', 'publicada');
    }

    public function scopePendientes($query)
    {
        return $query->where('estado', 'pendiente');
    }

    public function scopePorCarrera($query, $carreraClave)
    {
        // Usar LIKE para compatibilidad con SQLite
        return $query->where('carreras_dirigidas', 'LIKE', '%"' . $carreraClave . '"%');
    }

    public function scopePorTipo($query, $tipo)
    {
        return $query->where('tipo', $tipo);
    }

    protected function tipoTexto(): Attribute
    {
        return Attribute::make(
            get: fn (mixed $value, array $attributes) => 
                $attributes['tipo'] === 'servicio_social' ? 'Servicio Social' : 'Residencia Profesional'
        );
    }

    protected function estadoTexto(): Attribute
    {
        return Attribute::make(
            get: fn (mixed $value, array $attributes) => match($attributes['estado']) {
                'pendiente' => 'Pendiente',
                'publicada' => 'Publicada',
                'cerrada' => 'Cerrada',
                default => 'Sin estado'
            }
        );
    }
}
