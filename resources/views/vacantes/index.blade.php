@extends('layouts.app')

@section('title', 'Vacantes Disponibles')
@section('header', 'Vacantes Disponibles')
@section('subtitle', 'Encuentra la oportunidad perfecta para tu Servicio Social o Residencia Profesional')

@section('content')
<div class="row">
    <!-- Filtros -->
    <div class="col-lg-3 mb-4">
        <div class="filter-section">
            <h5 class="fw-bold mb-3">
                <i class="bi bi-funnel-fill text-primary me-2"></i>Filtrar Vacantes
            </h5>
            
            <form method="GET" action="{{ route('vacantes.index') }}">
                <!-- Búsqueda por texto -->
                <div class="mb-3">
                    <label for="buscar" class="form-label">Buscar</label>
                    <input type="text" class="form-control" id="buscar" name="buscar" 
                           value="{{ request('buscar') }}" placeholder="Título o descripción...">
                </div>

                <!-- Filtro por carrera -->
                <div class="mb-3">
                    <label for="carrera" class="form-label">Carrera</label>
                    <select class="form-select" id="carrera" name="carrera">
                        <option value="">Todas las carreras</option>
                        @foreach($carreras as $carrera)
                            <option value="{{ $carrera->clave }}" 
                                    @if(request('carrera') == $carrera->clave) selected @endif>
                                {{ $carrera->clave }} - {{ $carrera->nombre_carrera }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Filtro por tipo -->
                <div class="mb-3">
                    <label for="tipo" class="form-label">Tipo</label>
                    <select class="form-select" id="tipo" name="tipo">
                        <option value="">Todos los tipos</option>
                        <option value="servicio_social" @if(request('tipo') == 'servicio_social') selected @endif>
                            Servicio Social
                        </option>
                        <option value="residencia_profesional" @if(request('tipo') == 'residencia_profesional') selected @endif>
                            Residencia Profesional
                        </option>
                    </select>
                </div>

                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-search me-1"></i> Buscar
                    </button>
                    <a href="{{ route('vacantes.index') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-clockwise me-1"></i> Limpiar
                    </a>
                </div>
            </form>
        </div>

        <!-- Estadísticas rápidas -->
        <div class="card stats-card">
            <div class="card-body text-center">
                <h3 class="fw-bold mb-1">{{ $vacantes->total() }}</h3>
                <p class="mb-0">Vacantes Disponibles</p>
            </div>
        </div>
    </div>

    <!-- Lista de vacantes -->
    <div class="col-lg-9">
        @if($vacantes->count() > 0)
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="mb-0">
                    Mostrando {{ $vacantes->count() }} de {{ $vacantes->total() }} vacantes
                </h4>
                <a href="{{ route('vacantes.create') }}" class="btn btn-success">
                    <i class="bi bi-plus-circle-fill me-1"></i> Publicar Vacante
                </a>
            </div>

            <div class="row">
                @foreach($vacantes as $vacante)
                    <div class="col-lg-6 mb-4">
                        <div class="card vacante-card h-100">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start mb-3">
                                    <span class="badge {{ $vacante->tipo == 'servicio_social' ? 'badge-servicio' : 'badge-residencia' }} fs-6">
                                        {{ $vacante->tipo_texto }}
                                    </span>
                                    @if($vacante->con_beca)
                                        <span class="badge bg-warning text-dark">
                                            <i class="bi bi-currency-dollar"></i> Con Beca
                                        </span>
                                    @endif
                                </div>

                                <h5 class="card-title fw-bold text-primary">{{ $vacante->titulo }}</h5>
                                
                                <div class="mb-3">
                                    <h6 class="fw-semibold text-secondary mb-1">
                                        <i class="bi bi-building-fill me-1"></i>{{ $vacante->empresa->nombre_empresa }}
                                    </h6>
                                    <small class="text-muted">
                                        <i class="bi bi-geo-alt-fill me-1"></i>{{ $vacante->modalidad }}
                                        @if($vacante->duracion_meses)
                                            • {{ $vacante->duracion_meses }} meses
                                        @endif
                                    </small>
                                </div>

                                <p class="card-text text-muted">
                                    {{ Str::limit($vacante->descripcion, 120) }}
                                </p>

                                <div class="d-flex flex-wrap gap-1 mb-3">
                                    @foreach($vacante->carreras as $carrera)
                                        <span class="badge bg-light text-dark border">{{ $carrera->clave }}</span>
                                    @endforeach
                                </div>

                                <div class="d-flex justify-content-between align-items-center">
                                    <small class="text-muted">
                                        <i class="bi bi-calendar-fill me-1"></i>
                                        Publicada {{ $vacante->created_at->diffForHumans() }}
                                    </small>
                                    <div>
                                        <span class="badge bg-info me-2">
                                            {{ $vacante->postulaciones->count() }} postulaciones
                                        </span>
                                        <a href="{{ route('vacantes.show', $vacante) }}" class="btn btn-primary btn-sm">
                                            Ver Detalles <i class="bi bi-arrow-right ms-1"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Paginación -->
            <div class="d-flex justify-content-center">
                {{ $vacantes->appends(request()->query())->links() }}
            </div>
        @else
            <div class="text-center py-5">
                <div class="mb-4">
                    <i class="bi bi-search display-1 text-muted"></i>
                </div>
                <h4 class="text-muted mb-3">No se encontraron vacantes</h4>
                <p class="text-muted mb-4">
                    @if(request()->hasAny(['buscar', 'carrera', 'tipo']))
                        No hay vacantes que coincidan con tus filtros. Intenta con otros criterios de búsqueda.
                    @else
                        Actualmente no hay vacantes publicadas. ¡Vuelve pronto!
                    @endif
                </p>
                <div class="d-flex gap-3 justify-content-center">
                    <a href="{{ route('vacantes.index') }}" class="btn btn-outline-primary">
                        <i class="bi bi-arrow-clockwise me-1"></i> Ver Todas
                    </a>
                    <a href="{{ route('vacantes.create') }}" class="btn btn-success">
                        <i class="bi bi-plus-circle-fill me-1"></i> Publicar Primera Vacante
                    </a>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Auto-submit del formulario cuando cambian los filtros
    document.addEventListener('DOMContentLoaded', function() {
        const selects = document.querySelectorAll('select[name="carrera"], select[name="tipo"]');
        selects.forEach(select => {
            select.addEventListener('change', function() {
                this.form.submit();
            });
        });
    });
</script>
@endpush
