<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Empresa extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre_empresa',
        'contacto_rh',
        'correo',
        'telefono',
        'direccion',
        'sector_empresarial'
    ];

    public function vacantes()
    {
        return $this->hasMany(Vacante::class);
    }
}
