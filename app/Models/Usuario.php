<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Usuario extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'nombre',
        'correo',
        'password',
        'rol',
        'activo',
        'ultimo_acceso'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'activo' => 'boolean',
        'ultimo_acceso' => 'datetime',
    ];

    public function vacantesAprobadas()
    {
        return $this->hasMany(Vacante::class, 'aprobado_por');
    }

    public function isAdmin()
    {
        return $this->rol === 'admin';
    }

    public function isEditor()
    {
        return $this->rol === 'editor';
    }

    public function scopeActivos($query)
    {
        return $query->where('activo', true);
    }

    public function getRolTextoAttribute()
    {
        return match($this->rol) {
            'admin' => 'Administrador',
            'editor' => 'Editor',
            default => 'Sin rol'
        };
    }
}
