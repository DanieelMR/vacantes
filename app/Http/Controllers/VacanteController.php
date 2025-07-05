<?php

namespace App\Http\Controllers;

use App\Models\Vacante;
use App\Models\Carrera;
use App\Models\Empresa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VacanteController extends Controller
{
    /**
     * Vista principal del portal público
     */
    public function index(Request $request)
    {
        $query = Vacante::with(['empresa', 'postulaciones'])
            ->publicadas()
            ->orderBy('created_at', 'desc');

        // Filtro por carrera
        if ($request->filled('carrera')) {
            $query->porCarrera($request->carrera);
        }

        // Filtro por tipo
        if ($request->filled('tipo')) {
            $query->porTipo($request->tipo);
        }

        // Búsqueda por texto
        if ($request->filled('buscar')) {
            $buscar = $request->buscar;
            $query->where(function($q) use ($buscar) {
                $q->where('titulo', 'ILIKE', "%{$buscar}%")
                  ->orWhere('descripcion', 'ILIKE', "%{$buscar}%");
            });
        }

        $vacantes = $query->paginate(12);
        $carreras = Carrera::activas()->orderBy('nombre_carrera')->get();

        return view('vacantes.index', compact('vacantes', 'carreras'));
    }

    /**
     * Mostrar detalles de una vacante específica
     */
    public function show(Vacante $vacante)
    {
        if ($vacante->estado !== 'publicada') {
            abort(404);
        }

        $vacante->load(['empresa', 'postulaciones']);
        
        return view('vacantes.show', compact('vacante'));
    }

    /**
     * Mostrar formulario para empresas
     */
    public function create()
    {
        $carreras = Carrera::activas()->orderBy('nombre_carrera')->get();
        return view('vacantes.create', compact('carreras'));
    }

    /**
     * Procesar solicitud de vacante de empresa
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre_empresa' => 'required|string|max:150',
            'contacto_rh' => 'required|string|max:100',
            'correo_empresa' => 'required|email|max:100',
            'telefono_empresa' => 'nullable|string|max:20',
            'direccion' => 'nullable|string',
            'sector_empresarial' => 'nullable|string|max:50',
            'titulo_vacante' => 'required|string|max:150',
            'descripcion' => 'required|string',
            'tipo' => 'required|in:servicio_social,residencia_profesional',
            'carreras_dirigidas' => 'required|array|min:1',
            'carreras_dirigidas.*' => 'exists:carreras,id',
            'requisitos' => 'nullable|string',
            'modalidad' => 'required|in:presencial,remoto,hibrido',
            'duracion_meses' => 'nullable|numeric|min:1|max:12',
            'con_beca' => 'boolean',
            'monto_beca' => 'nullable|numeric|min:0',
            'fecha_inicio' => 'nullable|date|after:today',
            'fecha_limite_postulacion' => 'nullable|date|after:today',
            'num_plazas' => 'required|integer|min:1|max:50'
        ]);

        DB::transaction(function () use ($validated) {
            // Crear o encontrar empresa
            $empresa = Empresa::firstOrCreate(
                ['correo' => $validated['correo_empresa']],
                [
                    'nombre_empresa' => $validated['nombre_empresa'],
                    'contacto_rh' => $validated['contacto_rh'],
                    'telefono' => $validated['telefono_empresa'],
                    'direccion' => $validated['direccion'],
                    'sector_empresarial' => $validated['sector_empresarial']
                ]
            );

            // Crear vacante
            Vacante::create([
                'titulo' => $validated['titulo_vacante'],
                'descripcion' => $validated['descripcion'],
                'tipo' => $validated['tipo'],
                'empresa_id' => $empresa->id,
                'carreras_dirigidas' => $validated['carreras_dirigidas'],
                'requisitos' => $validated['requisitos'],
                'modalidad' => $validated['modalidad'],
                'duracion_meses' => $validated['duracion_meses'],
                'con_beca' => $validated['con_beca'] ?? false,
                'monto_beca' => $validated['con_beca'] ? $validated['monto_beca'] : null,
                'fecha_inicio' => $validated['fecha_inicio'],
                'fecha_limite_postulacion' => $validated['fecha_limite_postulacion'],
                'num_plazas' => $validated['num_plazas'],
                'estado' => 'pendiente'
            ]);
        });

        return redirect()->route('vacantes.create')
            ->with('success', '¡Vacante enviada correctamente! Será revisada por nuestro equipo antes de ser publicada.');
    }
}
