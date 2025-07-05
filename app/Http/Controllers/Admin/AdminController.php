<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Vacante;
use App\Models\Postulacion;
use App\Models\Empresa;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['dashboard']);
    }

    /**
     * Dashboard principal del administrador
     */
    public function dashboard()
    {
        $stats = [
            'vacantes_pendientes' => Vacante::pendientes()->count(),
            'vacantes_publicadas' => Vacante::publicadas()->count(),
            'postulaciones_totales' => Postulacion::count(),
            'empresas_registradas' => Empresa::count(),
            'postulaciones_mes' => Postulacion::whereMonth('created_at', now()->month)->count()
        ];

        $vacantes_recientes = Vacante::with('empresa')
            ->pendientes()
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        $postulaciones_recientes = Postulacion::with(['vacante', 'carrera'])
            ->orderBy('fecha_postulacion', 'desc')
            ->limit(10)
            ->get();

        return view('admin.dashboard', compact('stats', 'vacantes_recientes', 'postulaciones_recientes'));
    }

    /**
     * Listado de vacantes pendientes
     */
    public function vacantes(Request $request)
    {
        $query = Vacante::with(['empresa', 'postulaciones']);

        // Filtro por estado
        $estado = $request->get('estado', 'pendiente');
        if ($estado && $estado !== 'todas') {
            $query->where('estado', $estado);
        }

        $vacantes = $query->orderBy('created_at', 'desc')->paginate(15);

        return view('admin.vacantes.index', compact('vacantes', 'estado'));
    }

    /**
     * Ver detalles de una vacante para administración
     */
    public function verVacante(Vacante $vacante)
    {
        $vacante->load(['empresa', 'postulaciones.carrera', 'aprobadoPor']);
        
        return view('admin.vacantes.show', compact('vacante'));
    }

    /**
     * Aprobar vacante
     */
    public function aprobarVacante(Vacante $vacante)
    {
        $vacante->update([
            'estado' => 'publicada',
            'fecha_aprobacion' => now(),
            'aprobado_por' => Auth::id()
        ]);

        return back()->with('success', 'Vacante aprobada y publicada correctamente.');
    }

    /**
     * Rechazar vacante
     */
    public function rechazarVacante(Request $request, Vacante $vacante)
    {
        $request->validate([
            'observaciones' => 'required|string|max:500'
        ]);

        $vacante->update([
            'estado' => 'cerrada',
            'observaciones_admin' => $request->observaciones
        ]);

        return back()->with('success', 'Vacante rechazada.');
    }

    /**
     * Cerrar vacante
     */
    public function cerrarVacante(Vacante $vacante)
    {
        $vacante->update(['estado' => 'cerrada']);

        return back()->with('success', 'Vacante cerrada correctamente.');
    }

    /**
     * Ver todas las postulaciones
     */
    public function postulaciones(Request $request)
    {
        $query = Postulacion::with(['vacante.empresa', 'carrera']);

        // Filtro por estado
        if ($request->filled('estado')) {
            $query->where('estado_postulacion', $request->estado);
        }

        // Filtro por carrera
        if ($request->filled('carrera')) {
            $query->where('carrera_id', $request->carrera);
        }

        $postulaciones = $query->orderBy('fecha_postulacion', 'desc')->paginate(20);

        return view('admin.postulaciones.index', compact('postulaciones'));
    }

    /**
     * Gestión de usuarios (solo admin)
     */
    public function usuarios()
    {
        $this->authorize('admin-only');
        
        $usuarios = Usuario::orderBy('created_at', 'desc')->paginate(15);
        
        return view('admin.usuarios.index', compact('usuarios'));
    }

    /**
     * Crear nuevo usuario
     */
    public function crearUsuario(Request $request)
    {
        $this->authorize('admin-only');

        $validated = $request->validate([
            'nombre' => 'required|string|max:100',
            'correo' => 'required|email|unique:usuarios,correo',
            'password' => 'required|string|min:6',
            'rol' => 'required|in:admin,editor'
        ]);

        Usuario::create([
            'nombre' => $validated['nombre'],
            'correo' => $validated['correo'],
            'password' => bcrypt($validated['password']),
            'rol' => $validated['rol']
        ]);

        return back()->with('success', 'Usuario creado correctamente.');
    }
}
