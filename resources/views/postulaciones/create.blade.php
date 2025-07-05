@extends('layouts.app')

@section('title', 'Postularme a ' . $vacante->titulo)
@section('header', 'Postulación a Vacante')
@section('subtitle', $vacante->titulo . ' - ' . $vacante->empresa->nombre_empresa)

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <!-- Información de la vacante -->
        <div class="card mb-4">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <div class="d-flex gap-2 mb-2">
                            <span class="badge {{ $vacante->tipo == 'servicio_social' ? 'badge-servicio' : 'badge-residencia' }} fs-6">
                                {{ $vacante->tipo_texto }}
                            </span>
                            @if($vacante->con_beca)
                                <span class="badge bg-warning text-dark">
                                    <i class="bi bi-currency-dollar"></i> Con Beca
                                </span>
                            @endif
                        </div>
                        <h4 class="fw-bold text-primary mb-1">{{ $vacante->titulo }}</h4>
                        <h6 class="text-secondary mb-2">
                            <i class="bi bi-building-fill me-1"></i>{{ $vacante->empresa->nombre_empresa }}
                        </h6>
                        <div class="text-muted">
                            <i class="bi bi-geo-alt-fill me-1"></i>{{ ucfirst($vacante->modalidad) }}
                            @if($vacante->duracion_meses)
                                • {{ $vacante->duracion_meses }} meses
                            @endif
                        </div>
                    </div>
                    <a href="{{ route('vacantes.show', $vacante) }}" class="btn btn-outline-primary btn-sm">
                        <i class="bi bi-eye-fill me-1"></i> Ver Detalles
                    </a>
                </div>
            </div>
        </div>

        <!-- Formulario de postulación -->
        <div class="card">
            <div class="card-body p-4">
                <div class="text-center mb-4">
                    <h5 class="fw-bold text-primary">
                        <i class="bi bi-person-fill-add me-2"></i>Formulario de Postulación
                    </h5>
                    <p class="text-muted mb-0">Completa tus datos para postularte a esta vacante</p>
                </div>

                <form method="POST" action="{{ route('postulaciones.store', $vacante) }}">
                    @csrf
                    
                    <!-- Información Personal -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <h6 class="fw-bold text-secondary mb-3">
                                <i class="bi bi-person-badge-fill me-2"></i>Información Personal
                            </h6>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="nombre_estudiante" class="form-label">Nombre Completo <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('nombre_estudiante') is-invalid @enderror" 
                                   id="nombre_estudiante" name="nombre_estudiante" value="{{ old('nombre_estudiante') }}" 
                                   required placeholder="Tu nombre completo">
                            @error('nombre_estudiante')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="matricula" class="form-label">Matrícula <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('matricula') is-invalid @enderror" 
                                   id="matricula" name="matricula" value="{{ old('matricula') }}" 
                                   required placeholder="Ej: 20180123" style="text-transform: uppercase;">
                            @error('matricula')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="correo_est" class="form-label">Correo Electrónico <span class="text-danger">*</span></label>
                            <input type="email" class="form-control @error('correo_est') is-invalid @enderror" 
                                   id="correo_est" name="correo_est" value="{{ old('correo_est') }}" 
                                   required placeholder="tu.correo@gmail.com">
                            @error('correo_est')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="telefono_est" class="form-label">Teléfono</label>
                            <input type="tel" class="form-control @error('telefono_est') is-invalid @enderror" 
                                   id="telefono_est" name="telefono_est" value="{{ old('telefono_est') }}" 
                                   placeholder="Ej: 735 123 4567">
                            @error('telefono_est')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Información Académica -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <h6 class="fw-bold text-secondary mb-3">
                                <i class="bi bi-mortarboard-fill me-2"></i>Información Académica
                            </h6>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="carrera_id" class="form-label">Carrera <span class="text-danger">*</span></label>
                            <select class="form-select @error('carrera_id') is-invalid @enderror" id="carrera_id" name="carrera_id" required>
                                <option value="">Selecciona tu carrera...</option>
                                @foreach($carreras as $carrera)
                                    @if(in_array($carrera->id, $vacante->carreras_dirigidas))
                                        <option value="{{ $carrera->id }}" 
                                                @if(old('carrera_id') == $carrera->id) selected @endif>
                                            {{ $carrera->clave }} - {{ $carrera->nombre_carrera }}
                                        </option>
                                    @endif
                                @endforeach
                            </select>
                            @error('carrera_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Solo se muestran las carreras elegibles para esta vacante</div>
                        </div>

                        <div class="col-md-3 mb-3">
                            <label for="semestre_actual" class="form-label">Semestre Actual <span class="text-danger">*</span></label>
                            <select class="form-select @error('semestre_actual') is-invalid @enderror" id="semestre_actual" name="semestre_actual" required>
                                <option value="">Seleccionar...</option>
                                @for($i = 1; $i <= 12; $i++)
                                    <option value="{{ $i }}" @if(old('semestre_actual') == $i) selected @endif>
                                        {{ $i }}° Semestre
                                    </option>
                                @endfor
                            </select>
                            @error('semestre_actual')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-3 mb-3">
                            <label for="promedio" class="form-label">Promedio General</label>
                            <input type="number" class="form-control @error('promedio') is-invalid @enderror" 
                                   id="promedio" name="promedio" value="{{ old('promedio') }}" 
                                   min="0" max="100" step="0.01" placeholder="85.50">
                            @error('promedio')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Opcional</div>
                        </div>
                    </div>

                    <!-- Mensaje adicional -->
                    <div class="mb-4">
                        <label for="mensaje_adicional" class="form-label">Mensaje Adicional</label>
                        <textarea class="form-control @error('mensaje_adicional') is-invalid @enderror" 
                                  id="mensaje_adicional" name="mensaje_adicional" rows="4" 
                                  placeholder="Cuéntanos por qué te interesa esta vacante, tus habilidades relevantes o cualquier información adicional que consideres importante...">{{ old('mensaje_adicional') }}</textarea>
                        @error('mensaje_adicional')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">Este campo es opcional pero recomendado</div>
                    </div>

                    <!-- Información importante -->
                    <div class="alert alert-info">
                        <h6 class="fw-bold">
                            <i class="bi bi-info-circle-fill me-2"></i>Información Importante
                        </h6>
                        <ul class="mb-0">
                            <li>Al enviar este formulario, tus datos serán compartidos directamente con la empresa.</li>
                            <li>La empresa se pondrá en contacto contigo si tu perfil es seleccionado.</li>
                            <li>Solo puedes postularte una vez a cada vacante.</li>
                            <li>Asegúrate de que tus datos de contacto sean correctos.</li>
                        </ul>
                    </div>

                    <!-- Términos y condiciones -->
                    <div class="mb-4">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="acepto_terminos" required>
                            <label class="form-check-label" for="acepto_terminos">
                                Acepto compartir mis datos con la empresa y confirmo que la información proporcionada es veraz <span class="text-danger">*</span>
                            </label>
                        </div>
                    </div>

                    <!-- Botones -->
                    <div class="d-grid gap-2 d-md-flex justify-content-md-between">
                        <a href="{{ route('vacantes.show', $vacante) }}" class="btn btn-outline-secondary">
                            <i class="bi bi-arrow-left me-1"></i> Volver a la Vacante
                        </a>
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="bi bi-send-fill me-1"></i> Enviar Postulación
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Carreras elegibles -->
        <div class="card mt-4">
            <div class="card-body">
                <h6 class="fw-bold text-primary mb-3">
                    <i class="bi bi-mortarboard-fill me-2"></i>Carreras Elegibles para esta Vacante
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

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Convertir matrícula a mayúsculas
        const matriculaInput = document.getElementById('matricula');
        matriculaInput.addEventListener('input', function() {
            this.value = this.value.toUpperCase();
        });

        // Validación del formulario
        const form = document.querySelector('form');
        form.addEventListener('submit', function(e) {
            const terminosCheck = document.getElementById('acepto_terminos');
            if (!terminosCheck.checked) {
                e.preventDefault();
                alert('Debes aceptar los términos y condiciones para continuar.');
                terminosCheck.focus();
            }
        });

        // Formatear promedio
        const promedioInput = document.getElementById('promedio');
        promedioInput.addEventListener('blur', function() {
            if (this.value && !isNaN(this.value)) {
                const valor = parseFloat(this.value);
                if (valor > 10 && valor <= 100) {
                    // Promedio en escala 0-100
                } else if (valor > 4 && valor <= 10) {
                    // Promedio en escala 0-10, convertir a 0-100
                    this.value = (valor * 10).toFixed(2);
                }
            }
        });
    });
</script>
@endpush
