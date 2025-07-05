<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Carrera extends Model
{
    use HasFactory;

    protected $fillable = [
        'clave',
        'nombre_carrera',
        'activo'
    ];

    protected $casts = [
        'activo' => 'boolean',
    ];

    public function vacantes()
    {
        return $this->belongsToMany(Vacante::class, 'vacante_carrera');
    }

    public function postulaciones()
    {
        return $this->hasMany(Postulacion::class);
    }

    public function scopeActivas($query)
    {
        return $query->where('activo', true);
    }
}
