@extends('layouts.admin')

@section('title', 'Gestión de Vacantes')
@section('page-title', 'Gestión de Vacantes')
@section('page-subtitle', 'Revisar, aprobar y gestionar las vacantes del portal')

@section('content')
<!-- Filtros y estadísticas -->
<div class="row mb-4">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-body">
                <form method="GET" action="{{ route('admin.vacantes') }}" class="row g-3">
                    <div class="col-md-4">
                        <label for="estado" class="form-label">Filtrar por Estado</label>
                        <select class="form-select" id="estado" name="estado" onchange="this.form.submit()">
                            <option value="">Todos los estados</option>
                            <option value="pendiente" {{ $estado == 'pendiente' ? 'selected' : '' }}>
                                Pendientes
                            </option>
                            <option value="publicada" {{ $estado == 'publicada' ? 'selected' : '' }}>
                                Publicadas
                            </option>
                            <option value="cerrada" {{ $estado == 'cerrada' ? 'selected' : '' }}>
                                Cerradas
                            </option>
                        </select>
                    </div>
                    <div class="col-md-8 d-flex align-items-end">
                        <a href="{{ route('admin.vacantes') }}" class="btn btn-outline-secondary">
                            <i class="bi bi-arrow-clockwise me-1"></i> Limpiar Filtros
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4">
        <div class="card bg-primary text-white">
            <div class="card-body text-center">
                <h4 class="fw-bold">{{ $vacantes->total() }}</h4>
                <p class="mb-0">
                    @if($estado)
                        Vacantes {{ ucfirst($estado) }}
                    @else
                        Total de Vacantes
                    @endif
                </p>
            </div>
        </div>
    </div>
</div>

<!-- Lista de vacantes -->
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h6 class="fw-bold mb-0">
            <i class="bi bi-list-task me-2"></i>
            @switch($estado)
                @case('pendiente')
                    Vacantes Pendientes de Aprobación
                    @break
                @case('publicada')
                    Vacantes Publicadas
                    @break
                @case('cerrada')
                    Vacantes Cerradas
                    @break
                @default
                    Todas las Vacantes
            @endswitch
        </h6>
        
        @if($estado == 'pendiente' && $vacantes->count() > 0)
            <span class="badge bg-warning fs-6">{{ $vacantes->count() }} requieren atención</span>
        @endif
    </div>
    
    <div class="card-body p-0">
        @if($vacantes->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Vacante</th>
                            <th>Empresa</th>
                            <th>Tipo</th>
                            <th>Estado</th>
                            <th>Fecha</th>
                            <th>Postulaciones</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($vacantes as $vacante)
                            <tr>
                                <td>
                                    <div>
                                        <h6 class="mb-1 fw-semibold">{{ Str::limit($vacante->titulo, 40) }}</h6>
                                        <small class="text-muted">
                                            <i class="bi bi-geo-alt-fill me-1"></i>{{ ucfirst($vacante->modalidad) }}
                                            @if($vacante->duracion_meses)
                                                • {{ $vacante->duracion_meses }}m
                                            @endif
                                        </small>
                                    </div>
                                </td>
                                <td>
                                    <div>
                                        <div class="fw-medium">{{ Str::limit($vacante->empresa->nombre_empresa, 30) }}</div>
                                        <small class="text-muted">{{ $vacante->empresa->contacto_rh }}</small>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge {{ $vacante->tipo == 'servicio_social' ? 'bg-success' : 'bg-primary' }}">
                                        {{ $vacante->tipo == 'servicio_social' ? 'Servicio Social' : 'Residencia Prof.' }}
                                    </span>
                                </td>
                                <td>
                                    @switch($vacante->estado)
                                        @case('pendiente')
                                            <span class="badge bg-warning">
                                                <i class="bi bi-clock-fill me-1"></i>Pendiente
                                            </span>
                                            @break
                                        @case('publicada')
                                            <span class="badge bg-success">
                                                <i class="bi bi-check-circle-fill me-1"></i>Publicada
                                            </span>
                                            @break
                                        @case('cerrada')
                                            <span class="badge bg-secondary">
                                                <i class="bi bi-x-circle-fill me-1"></i>Cerrada
                                            </span>
                                            @break
                                    @endswitch
                                </td>
                                <td>
                                    <div>
                                        <small class="text-muted">{{ $vacante->created_at->format('d/m/Y') }}</small><br>
                                        <small class="text-muted">{{ $vacante->created_at->format('H:i') }}</small>
                                    </div>
                                </td>
                                <td>
                                    <div class="text-center">
                                        <span class="badge bg-info">{{ $vacante->postulaciones->count() }}</span>
                                        @if($vacante->num_plazas > 1)
                                            <br><small class="text-muted">de {{ $vacante->num_plazas }} plazas</small>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    <div class="btn-group btn-group-sm" role="group">
                                        <a href="{{ route('admin.vacantes.show', $vacante) }}" 
                                           class="btn btn-outline-primary btn-action" 
                                           title="Ver detalles">
                                            <i class="bi bi-eye-fill"></i>
                                        </a>
                                        
                                        @if($vacante->estado == 'pendiente')
                                            <form method="POST" action="{{ route('admin.vacantes.aprobar', $vacante) }}" 
                                                  class="d-inline" onsubmit="return confirm('¿Aprobar esta vacante?')">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="btn btn-outline-success btn-action" 
                                                        title="Aprobar vacante">
                                                    <i class="bi bi-check-lg"></i>
                                                </button>
                                            </form>
                                        @elseif($vacante->estado == 'publicada')
                                            <form method="POST" action="{{ route('admin.vacantes.cerrar', $vacante) }}" 
                                                  class="d-inline" onsubmit="return confirm('¿Cerrar esta vacante?')">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="btn btn-outline-secondary btn-action" 
                                                        title="Cerrar vacante">
                                                    <i class="bi bi-x-lg"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <!-- Paginación -->
            @if($vacantes->hasPages())
                <div class="card-footer">
                    <div class="d-flex justify-content-center">
                        {{ $vacantes->appends(request()->query())->links() }}
                    </div>
                </div>
            @endif
        @else
            <div class="text-center py-5">
                @switch($estado)
                    @case('pendiente')
                        <i class="bi bi-check-circle-fill display-1 text-success mb-3"></i>
                        <h5 class="text-muted">¡No hay vacantes pendientes!</h5>
                        <p class="text-muted">Todas las vacantes han sido procesadas.</p>
                        @break
                    @case('publicada')
                        <i class="bi bi-briefcase display-1 text-muted mb-3"></i>
                        <h5 class="text-muted">No hay vacantes publicadas</h5>
                        <p class="text-muted">Las vacantes aparecerán aquí una vez aprobadas.</p>
                        @break
                    @case('cerrada')
                        <i class="bi bi-archive display-1 text-muted mb-3"></i>
                        <h5 class="text-muted">No hay vacantes cerradas</h5>
                        <p class="text-muted">Las vacantes cerradas aparecerán aquí.</p>
                        @break
                    @default
                        <i class="bi bi-inbox display-1 text-muted mb-3"></i>
                        <h5 class="text-muted">No hay vacantes registradas</h5>
                        <p class="text-muted">Las empresas pueden publicar vacantes desde el portal público.</p>
                @endswitch
                
                <div class="mt-3">
                    @if($estado)
                        <a href="{{ route('admin.vacantes') }}" class="btn btn-outline-primary">
                            <i class="bi bi-arrow-left me-1"></i> Ver Todas las Vacantes
                        </a>
                    @endif
                    <a href="{{ route('vacantes.index') }}" class="btn btn-outline-success" target="_blank">
                        <i class="bi bi-box-arrow-up-right me-1"></i> Portal Público
                    </a>
                </div>
            </div>
        @endif
    </div>
</div>

<!-- Acciones masivas (si hay vacantes pendientes) -->
@if($estado == 'pendiente' && $vacantes->count() > 0)
    <div class="card mt-4">
        <div class="card-body">
            <h6 class="fw-bold text-primary mb-3">
                <i class="bi bi-lightning-fill me-2"></i>Acciones Rápidas
            </h6>
            <div class="alert alert-info">
                <i class="bi bi-info-circle-fill me-2"></i>
                <strong>{{ $vacantes->count() }} vacantes pendientes</strong> requieren tu atención. 
                Revisa cada una individualmente para aprobar o rechazar.
            </div>
        </div>
    </div>
@endif
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Auto-refresh every 60 seconds if viewing pending
        @if($estado == 'pendiente')
            setInterval(function() {
                if (!document.hidden) {
                    // Could implement auto-refresh here
                    console.log('Checking for new pending vacancies...');
                }
            }, 60000);
        @endif

        // Confirmation for batch actions
        const forms = document.querySelectorAll('form[onsubmit]');
        forms.forEach(form => {
            form.addEventListener('submit', function(e) {
                const action = this.querySelector('button[type="submit"]').title;
                if (!confirm(`¿Estás seguro de que deseas ${action.toLowerCase()}?`)) {
                    e.preventDefault();
                }
            });
        });
    });
</script>
@endpush
