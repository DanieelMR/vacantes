<?php

namespace App\Http\Controllers;

use App\Models\Postulacion;
use App\Models\Vacante;
use App\Models\Carrera;
use Illuminate\Http\Request;

class PostulacionController extends Controller
{
    /**
     * Mostrar formulario de postulación
     */
    public function create(Vacante $vacante)
    {
        if ($vacante->estado !== 'publicada') {
            abort(404);
        }

        $carreras = Carrera::activas()->orderBy('nombre_carrera')->get();
        
        return view('postulaciones.create', compact('vacante', 'carreras'));
    }

    /**
     * Procesar postulación de estudiante
     */
    public function store(Request $request, Vacante $vacante)
    {
        if ($vacante->estado !== 'publicada') {
            abort(404);
        }

        $validated = $request->validate([
            'nombre_estudiante' => 'required|string|max:100',
            'matricula' => 'required|string|max:20|regex:/^[A-Za-z0-9]+$/',
            'correo_est' => 'required|email|max:100',
            'telefono_est' => 'nullable|string|max:20',
            'carrera_id' => 'required|exists:carreras,id',
            'semestre_actual' => 'required|integer|min:1|max:12',
            'promedio' => 'nullable|numeric|min:0|max:100',
            'mensaje_adicional' => 'nullable|string|max:500'
        ]);

        // Verificar que la carrera esté en las carreras dirigidas de la vacante
        if (!in_array($validated['carrera_id'], $vacante->carreras_dirigidas)) {
            return back()->withErrors(['carrera_id' => 'Esta vacante no está dirigida a tu carrera.']);
        }

        // Verificar si ya se postuló anteriormente
        $postulacionExistente = Postulacion::where('vacante_id', $vacante->id)
            ->where('matricula', $validated['matricula'])
            ->first();

        if ($postulacionExistente) {
            return back()->withErrors(['matricula' => 'Ya te has postulado a esta vacante anteriormente.']);
        }

        // Crear postulación
        Postulacion::create([
            'vacante_id' => $vacante->id,
            'nombre_estudiante' => $validated['nombre_estudiante'],
            'matricula' => strtoupper($validated['matricula']),
            'correo_est' => $validated['correo_est'],
            'telefono_est' => $validated['telefono_est'],
            'carrera_id' => $validated['carrera_id'],
            'semestre_actual' => $validated['semestre_actual'],
            'promedio' => $validated['promedio'],
            'mensaje_adicional' => $validated['mensaje_adicional'],
            'fecha_postulacion' => now()
        ]);

        return redirect()->route('vacantes.show', $vacante)
            ->with('success', '¡Tu postulación ha sido enviada correctamente! La empresa recibirá tus datos para evaluación.');
    }
}
