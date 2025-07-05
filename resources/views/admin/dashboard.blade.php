@extends('layouts.admin')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')
@section('page-subtitle', 'Resumen general del portal de vacantes')

@section('content')
<!-- Estadísticas principales -->
<div class="row mb-4">
    <div class="col-md-6 col-lg-3 mb-3">
        <div class="card stats-card">
            <div class="card-body text-center">
                <i class="bi bi-exclamation-circle-fill display-4 mb-2 opacity-75"></i>
                <div class="stats-number">{{ $stats['vacantes_pendientes'] }}</div>
                <div class="fw-semibold">Vacantes Pendientes</div>
                <small class="opacity-75">Requieren revisión</small>
            </div>
        </div>
    </div>
    
    <div class="col-md-6 col-lg-3 mb-3">
        <div class="card" style="background: linear-gradient(135deg, #38a169, #2f855a); color: white;">
            <div class="card-body text-center">
                <i class="bi bi-check-circle-fill display-4 mb-2 opacity-75"></i>
                <div class="stats-number">{{ $stats['vacantes_publicadas'] }}</div>
                <div class="fw-semibold">Vacantes Publicadas</div>
                <small class="opacity-75">Actualmente activas</small>
            </div>
        </div>
    </div>
    
    <div class="col-md-6 col-lg-3 mb-3">
        <div class="card" style="background: linear-gradient(135deg, #3182ce, #2c5282); color: white;">
            <div class="card-body text-center">
                <i class="bi bi-people-fill display-4 mb-2 opacity-75"></i>
                <div class="stats-number">{{ $stats['postulaciones_totales'] }}</div>
                <div class="fw-semibold">Postulaciones Totales</div>
                <small class="opacity-75">Desde el inicio</small>
            </div>
        </div>
    </div>
    
    <div class="col-md-6 col-lg-3 mb-3">
        <div class="card" style="background: linear-gradient(135deg, #805ad5, #6b46c1); color: white;">
            <div class="card-body text-center">
                <i class="bi bi-building-fill display-4 mb-2 opacity-75"></i>
                <div class="stats-number">{{ $stats['empresas_registradas'] }}</div>
                <div class="fw-semibold">Empresas Registradas</div>
                <small class="opacity-75">En la plataforma</small>
            </div>
        </div>
    </div>
</div>

<!-- Estadística adicional -->
<div class="row mb-4">
    <div class="col-lg-4">
        <div class="card">
            <div class="card-body text-center">
                <h5 class="fw-bold text-primary mb-3">Actividad del Mes</h5>
                <div class="display-6 fw-bold text-success">{{ $stats['postulaciones_mes'] }}</div>
                <p class="text-muted mb-0">Postulaciones en {{ now()->format('F Y') }}</p>
            </div>
        </div>
    </div>
    
    <div class="col-lg-8">
        <div class="card">
            <div class="card-body">
                <h5 class="fw-bold text-primary mb-3">
                    <i class="bi bi-graph-up me-2"></i>Acciones Rápidas
                </h5>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <a href="{{ route('admin.vacantes', ['estado' => 'pendiente']) }}" 
                           class="btn btn-warning w-100 d-flex align-items-center justify-content-between">
                            <span>
                                <i class="bi bi-eye-fill me-2"></i>Revisar Pendientes
                            </span>
                            @if($stats['vacantes_pendientes'] > 0)
                                <span class="badge bg-light text-dark">{{ $stats['vacantes_pendientes'] }}</span>
                            @endif
                        </a>
                    </div>
                    <div class="col-md-6 mb-3">
                        <a href="{{ route('admin.vacantes', ['estado' => 'publicada']) }}" 
                           class="btn btn-success w-100">
                            <i class="bi bi-list-ul me-2"></i>Ver Publicadas
                        </a>
                    </div>
                    <div class="col-md-6 mb-3">
                        <a href="{{ route('admin.postulaciones') }}" 
                           class="btn btn-info w-100">
                            <i class="bi bi-people-fill me-2"></i>Ver Postulaciones
                        </a>
                    </div>
                    <div class="col-md-6 mb-3">
                        <a href="{{ route('vacantes.index') }}" 
                           class="btn btn-outline-primary w-100" target="_blank">
                            <i class="bi bi-box-arrow-up-right me-2"></i>Portal Público
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Vacantes pendientes recientes -->
    <div class="col-lg-6 mb-4">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h6 class="fw-bold mb-0">
                    <i class="bi bi-clock-fill me-2 text-warning"></i>Vacantes Pendientes Recientes
                </h6>
                <a href="{{ route('admin.vacantes', ['estado' => 'pendiente']) }}" 
                   class="btn btn-sm btn-outline-primary">Ver Todas</a>
            </div>
            <div class="card-body p-0">
                @if($vacantes_recientes->count() > 0)
                    <div class="list-group list-group-flush">
                        @foreach($vacantes_recientes as $vacante)
                            <div class="list-group-item">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div class="flex-grow-1">
                                        <h6 class="mb-1 fw-semibold">{{ $vacante->titulo }}</h6>
                                        <p class="mb-1 text-muted">{{ $vacante->empresa->nombre_empresa }}</p>
                                        <small class="text-muted">
                                            <i class="bi bi-calendar-fill me-1"></i>
                                            {{ $vacante->created_at->diffForHumans() }}
                                        </small>
                                    </div>
                                    <div class="text-end">
                                        <span class="badge {{ $vacante->tipo == 'servicio_social' ? 'bg-success' : 'bg-primary' }}">
                                            {{ $vacante->tipo == 'servicio_social' ? 'SS' : 'RP' }}
                                        </span>
                                        <div class="mt-1">
                                            <a href="{{ route('admin.vacantes.show', $vacante) }}" 
                                               class="btn btn-sm btn-outline-primary">
                                                <i class="bi bi-eye-fill"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-4">
                        <i class="bi bi-check-circle-fill display-4 text-success mb-3"></i>
                        <h6 class="text-muted">¡No hay vacantes pendientes!</h6>
                        <p class="text-muted mb-0">Todas las vacantes han sido procesadas.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Postulaciones recientes -->
    <div class="col-lg-6 mb-4">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h6 class="fw-bold mb-0">
                    <i class="bi bi-person-plus-fill me-2 text-info"></i>Postulaciones Recientes
                </h6>
                <a href="{{ route('admin.postulaciones') }}" 
                   class="btn btn-sm btn-outline-primary">Ver Todas</a>
            </div>
            <div class="card-body p-0">
                @if($postulaciones_recientes->count() > 0)
                    <div class="list-group list-group-flush">
                        @foreach($postulaciones_recientes->take(8) as $postulacion)
                            <div class="list-group-item">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="flex-grow-1">
                                        <h6 class="mb-1 fw-semibold">{{ $postulacion->nombre_estudiante }}</h6>
                                        <p class="mb-1 text-muted small">
                                            {{ Str::limit($postulacion->vacante->titulo, 40) }}
                                        </p>
                                        <small class="text-muted">
                                            <i class="bi bi-mortarboard-fill me-1"></i>
                                            {{ $postulacion->carrera->clave }}
                                            • {{ $postulacion->fecha_postulacion->diffForHumans() }}
                                        </small>
                                    </div>
                                    <div class="text-end">
                                        <span class="badge bg-light text-dark">
                                            {{ $postulacion->matricula }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-4">
                        <i class="bi bi-person-x-fill display-4 text-muted mb-3"></i>
                        <h6 class="text-muted">Sin postulaciones recientes</h6>
                        <p class="text-muted mb-0">Aún no hay estudiantes postulándose.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Información del sistema -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h6 class="fw-bold text-primary mb-3">
                    <i class="bi bi-info-circle-fill me-2"></i>Información del Sistema
                </h6>
                <div class="row">
                    <div class="col-md-3">
                        <strong>Usuario actual:</strong><br>
                        <span class="text-muted">{{ Auth::user()->nombre }}</span><br>
                        <span class="badge bg-primary">{{ Auth::user()->rol_texto }}</span>
                    </div>
                    <div class="col-md-3">
                        <strong>Último acceso:</strong><br>
                        <span class="text-muted">
                            @if(Auth::user()->ultimo_acceso)
                                {{ Auth::user()->ultimo_acceso->format('d/m/Y H:i') }}
                            @else
                                Primer acceso
                            @endif
                        </span>
                    </div>
                    <div class="col-md-3">
                        <strong>Versión del portal:</strong><br>
                        <span class="text-muted">v2.0</span>
                    </div>
                    <div class="col-md-3">
                        <strong>Fecha actual:</strong><br>
                        <span class="text-muted">{{ now()->format('d/m/Y H:i') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Auto-refresh stats every 30 seconds
        setInterval(function() {
            // Only refresh if page is visible
            if (!document.hidden) {
                // You could implement AJAX refresh here if needed
                console.log('Auto-refresh check - Dashboard active');
            }
        }, 30000);

        // Highlight pending vacancies if there are any
        @if($stats['vacantes_pendientes'] > 0)
            console.log('{{ $stats['vacantes_pendientes'] }} vacantes pendientes requieren atención');
        @endif
    });
</script>
@endpush
