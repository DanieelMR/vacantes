@extends('layouts.app')

@section('title', $vacante->titulo)
@section('header', $vacante->titulo)
@section('subtitle', $vacante->empresa->nombre_empresa)

@section('content')
<div class="row">
    <div class="col-lg-8 mb-4">
        <div class="card">
            <div class="card-body p-4">
                <!-- Header de la vacante -->
                <div class="d-flex justify-content-between align-items-start mb-4">
                    <div>
                        <div class="d-flex gap-2 mb-3">
                            <span class="badge {{ $vacante->tipo == 'servicio_social' ? 'badge-servicio' : 'badge-residencia' }} fs-6">
                                {{ $vacante->tipo_texto }}
                            </span>
                            @if($vacante->con_beca)
                                <span class="badge bg-warning text-dark">
                                    <i class="bi bi-currency-dollar"></i> Beca: ${{ number_format($vacante->monto_beca, 2) }}
                                </span>
                            @endif
                            <span class="badge bg-info">
                                <i class="bi bi-people-fill"></i> {{ $vacante->postulaciones->count() }} postulaciones
                            </span>
                        </div>
                        <h1 class="h3 fw-bold text-primary mb-2">{{ $vacante->titulo }}</h1>
                        <h5 class="text-secondary mb-0">
                            <i class="bi bi-building-fill me-2"></i>{{ $vacante->empresa->nombre_empresa }}
                        </h5>
                    </div>
                    <div class="text-end">
                        <div class="text-muted small">
                            <i class="bi bi-calendar-fill me-1"></i>
                            Publicada {{ $vacante->created_at->diffForHumans() }}
                        </div>
                    </div>
                </div>

                <!-- Información básica -->
                <div class="row mb-4">
                    <div class="col-md-6">
                        <h6 class="fw-bold text-primary mb-3">
                            <i class="bi bi-info-circle-fill me-2"></i>Detalles de la Vacante
                        </h6>
                        <ul class="list-unstyled">
                            <li class="mb-2">
                                <strong>Modalidad:</strong> 
                                <span class="text-capitalize">{{ $vacante->modalidad }}</span>
                            </li>
                            @if($vacante->duracion_meses)
                                <li class="mb-2">
                                    <strong>Duración:</strong> {{ $vacante->duracion_meses }} meses
                                </li>
                            @endif
                            <li class="mb-2">
                                <strong>Plazas disponibles:</strong> {{ $vacante->num_plazas }}
                            </li>
                            @if($vacante->fecha_inicio)
                                <li class="mb-2">
                                    <strong>Fecha de inicio:</strong> {{ $vacante->fecha_inicio->format('d/m/Y') }}
                                </li>
                            @endif
                            @if($vacante->fecha_limite_postulacion)
                                <li class="mb-2">
                                    <strong>Fecha límite:</strong> 
                                    <span class="@if($vacante->fecha_limite_postulacion->isPast()) text-danger @endif">
                                        {{ $vacante->fecha_limite_postulacion->format('d/m/Y') }}
                                    </span>
                                </li>
                            @endif
                        </ul>
                    </div>
                    
                    <div class="col-md-6">
                        <h6 class="fw-bold text-primary mb-3">
                            <i class="bi bi-mortarboard-fill me-2"></i>Carreras Dirigidas
                        </h6>
                        <div class="d-flex flex-wrap gap-2">
                            @foreach($vacante->carreras() as $carrera)
                                <span class="badge bg-light text-dark border fs-6 p-2">
                                    {{ $carrera->clave }} - {{ $carrera->nombre_carrera }}
                                </span>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Descripción -->
                <div class="mb-4">
                    <h6 class="fw-bold text-primary mb-3">
                        <i class="bi bi-file-text-fill me-2"></i>Descripción
                    </h6>
                    <div class="text-muted lh-lg">
                        {!! nl2br(e($vacante->descripcion)) !!}
                    </div>
                </div>

                <!-- Requisitos -->
                @if($vacante->requisitos)
                    <div class="mb-4">
                        <h6 class="fw-bold text-primary mb-3">
                            <i class="bi bi-check-square-fill me-2"></i>Requisitos
                        </h6>
                        <div class="text-muted lh-lg">
                            {!! nl2br(e($vacante->requisitos)) !!}
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Sidebar -->
    <div class="col-lg-4">
        <!-- Información de contacto -->
        <div class="card mb-4">
            <div class="card-body">
                <h6 class="fw-bold text-primary mb-3">
                    <i class="bi bi-person-lines-fill me-2"></i>Información de Contacto
                </h6>
                <div class="mb-3">
                    <strong>Empresa:</strong><br>
                    <span class="text-muted">{{ $vacante->empresa->nombre_empresa }}</span>
                </div>
                <div class="mb-3">
                    <strong>Contacto RH:</strong><br>
                    <span class="text-muted">{{ $vacante->empresa->contacto_rh }}</span>
                </div>
                <div class="mb-3">
                    <strong>Correo:</strong><br>
                    <a href="mailto:{{ $vacante->empresa->correo }}" class="text-primary">
                        {{ $vacante->empresa->correo }}
                    </a>
                </div>
                @if($vacante->empresa->telefono)
                    <div class="mb-3">
                        <strong>Teléfono:</strong><br>
                        <a href="tel:{{ $vacante->empresa->telefono }}" class="text-primary">
                            {{ $vacante->empresa->telefono }}
                        </a>
                    </div>
                @endif
                @if($vacante->empresa->sector_empresarial)
                    <div class="mb-0">
                        <strong>Sector:</strong><br>
                        <span class="text-muted">{{ $vacante->empresa->sector_empresarial }}</span>
                    </div>
                @endif
            </div>
        </div>

        <!-- Botón de postulación -->
        <div class="card">
            <div class="card-body text-center">
                @if($vacante->fecha_limite_postulacion && $vacante->fecha_limite_postulacion->isPast())
                    <div class="alert alert-warning mb-3">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i>
                        La fecha límite de postulación ha vencido
                    </div>
                    <button class="btn btn-secondary btn-lg w-100" disabled>
                        <i class="bi bi-clock-fill me-2"></i>Vacante Vencida
                    </button>
                @else
                    <h6 class="fw-bold mb-3">¿Te interesa esta vacante?</h6>
                    <a href="{{ route('postulaciones.create', $vacante) }}" 
                       class="btn btn-primary btn-lg w-100 mb-3">
                        <i class="bi bi-send-fill me-2"></i>Postularme
                    </a>
                    <small class="text-muted">
                        ✓ Sin registro necesario<br>
                        ✓ Proceso rápido y sencillo
                    </small>
                @endif
            </div>
        </div>

        <!-- Estadísticas -->
        <div class="card mt-4">
            <div class="card-body">
                <h6 class="fw-bold text-primary mb-3">
                    <i class="bi bi-graph-up me-2"></i>Estadísticas
                </h6>
                <div class="row text-center">
                    <div class="col-6">
                        <div class="fw-bold h4 text-primary">{{ $vacante->postulaciones->count() }}</div>
                        <small class="text-muted">Postulaciones</small>
                    </div>
                    <div class="col-6">
                        <div class="fw-bold h4 text-success">{{ $vacante->num_plazas }}</div>
                        <small class="text-muted">Plazas</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Navegación -->
        <div class="card mt-4">
            <div class="card-body">
                <h6 class="fw-bold text-primary mb-3">
                    <i class="bi bi-arrow-left-right me-2"></i>Navegación
                </h6>
                <div class="d-grid gap-2">
                    <a href="{{ route('vacantes.index') }}" class="btn btn-outline-primary">
                        <i class="bi bi-arrow-left me-1"></i> Ver Todas las Vacantes
                    </a>
                    <a href="{{ route('vacantes.create') }}" class="btn btn-outline-success">
                        <i class="bi bi-plus-circle me-1"></i> Publicar Vacante
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .badge-servicio {
        background-color: #38a169;
    }
    .badge-residencia {
        background-color: #3182ce;
    }
</style>
@endpush
