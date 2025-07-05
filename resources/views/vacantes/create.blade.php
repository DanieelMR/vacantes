@extends('layouts.app')

@section('title', 'Publicar Vacante')
@section('header', 'Publicar Nueva Vacante')
@section('subtitle', 'Completa el formulario para enviar tu solicitud de vacante')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-body p-4">
                <form method="POST" action="{{ route('vacantes.store') }}">
                    @csrf
                    
                    <!-- Información de la Empresa -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <h5 class="fw-bold text-primary mb-3">
                                <i class="bi bi-building-fill me-2"></i>Información de la Empresa
                            </h5>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="nombre_empresa" class="form-label">Nombre de la Empresa <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('nombre_empresa') is-invalid @enderror" 
                                   id="nombre_empresa" name="nombre_empresa" value="{{ old('nombre_empresa') }}" required>
                            @error('nombre_empresa')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="contacto_rh" class="form-label">Contacto de RH <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('contacto_rh') is-invalid @enderror" 
                                   id="contacto_rh" name="contacto_rh" value="{{ old('contacto_rh') }}" required>
                            @error('contacto_rh')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="correo_empresa" class="form-label">Correo Electrónico <span class="text-danger">*</span></label>
                            <input type="email" class="form-control @error('correo_empresa') is-invalid @enderror" 
                                   id="correo_empresa" name="correo_empresa" value="{{ old('correo_empresa') }}" required>
                            @error('correo_empresa')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="telefono_empresa" class="form-label">Teléfono</label>
                            <input type="tel" class="form-control @error('telefono_empresa') is-invalid @enderror" 
                                   id="telefono_empresa" name="telefono_empresa" value="{{ old('telefono_empresa') }}">
                            @error('telefono_empresa')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="sector_empresarial" class="form-label">Sector Empresarial</label>
                            <select class="form-select @error('sector_empresarial') is-invalid @enderror" 
                                    id="sector_empresarial" name="sector_empresarial">
                                <option value="">Seleccionar sector...</option>
                                <option value="Tecnología" {{ old('sector_empresarial') == 'Tecnología' ? 'selected' : '' }}>Tecnología</option>
                                <option value="Manufactura" {{ old('sector_empresarial') == 'Manufactura' ? 'selected' : '' }}>Manufactura</option>
                                <option value="Servicios" {{ old('sector_empresarial') == 'Servicios' ? 'selected' : '' }}>Servicios</option>
                                <option value="Construcción" {{ old('sector_empresarial') == 'Construcción' ? 'selected' : '' }}>Construcción</option>
                                <option value="Automotriz" {{ old('sector_empresarial') == 'Automotriz' ? 'selected' : '' }}>Automotriz</option>
                                <option value="Alimentos" {{ old('sector_empresarial') == 'Alimentos' ? 'selected' : '' }}>Alimentos</option>
                                <option value="Gobierno" {{ old('sector_empresarial') == 'Gobierno' ? 'selected' : '' }}>Gobierno</option>
                                <option value="Educación" {{ old('sector_empresarial') == 'Educación' ? 'selected' : '' }}>Educación</option>
                                <option value="Otro" {{ old('sector_empresarial') == 'Otro' ? 'selected' : '' }}>Otro</option>
                            </select>
                            @error('sector_empresarial')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="direccion" class="form-label">Dirección</label>
                            <textarea class="form-control @error('direccion') is-invalid @enderror" 
                                      id="direccion" name="direccion" rows="2">{{ old('direccion') }}</textarea>
                            @error('direccion')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <hr>

                    <!-- Información de la Vacante -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <h5 class="fw-bold text-primary mb-3">
                                <i class="bi bi-briefcase-fill me-2"></i>Información de la Vacante
                            </h5>
                        </div>

                        <div class="col-md-8 mb-3">
                            <label for="titulo_vacante" class="form-label">Título de la Vacante <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('titulo_vacante') is-invalid @enderror" 
                                   id="titulo_vacante" name="titulo_vacante" value="{{ old('titulo_vacante') }}" 
                                   placeholder="Ej: Desarrollador Web Junior, Asistente de Ingeniería..." required>
                            @error('titulo_vacante')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="tipo" class="form-label">Tipo <span class="text-danger">*</span></label>
                            <select class="form-select @error('tipo') is-invalid @enderror" id="tipo" name="tipo" required>
                                <option value="">Seleccionar...</option>
                                <option value="servicio_social" {{ old('tipo') == 'servicio_social' ? 'selected' : '' }}>
                                    Servicio Social
                                </option>
                                <option value="residencia_profesional" {{ old('tipo') == 'residencia_profesional' ? 'selected' : '' }}>
                                    Residencia Profesional
                                </option>
                            </select>
                            @error('tipo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-12 mb-3">
                            <label for="descripcion" class="form-label">Descripción de la Vacante <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('descripcion') is-invalid @enderror" 
                                      id="descripcion" name="descripcion" rows="4" required 
                                      placeholder="Describe las actividades, responsabilidades y objetivos de la vacante...">{{ old('descripcion') }}</textarea>
                            @error('descripcion')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-12 mb-3">
                            <label class="form-label">Carreras Dirigidas <span class="text-danger">*</span></label>
                            <div class="row">
                                @foreach($carreras as $carrera)
                                    <div class="col-md-6 col-lg-4 mb-2">
                                        <div class="form-check">
                                            <input class="form-check-input @error('carreras_dirigidas') is-invalid @enderror" 
                                                   type="checkbox" value="{{ $carrera->id }}" 
                                                   id="carrera_{{ $carrera->id }}" name="carreras_dirigidas[]"
                                                   {{ in_array($carrera->id, old('carreras_dirigidas', [])) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="carrera_{{ $carrera->id }}">
                                                {{ $carrera->clave }} - {{ $carrera->nombre_carrera }}
                                            </label>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            @error('carreras_dirigidas')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-12 mb-3">
                            <label for="requisitos" class="form-label">Requisitos</label>
                            <textarea class="form-control @error('requisitos') is-invalid @enderror" 
                                      id="requisitos" name="requisitos" rows="3"
                                      placeholder="Menciona los requisitos específicos, habilidades o conocimientos necesarios...">{{ old('requisitos') }}</textarea>
                            @error('requisitos')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="modalidad" class="form-label">Modalidad <span class="text-danger">*</span></label>
                            <select class="form-select @error('modalidad') is-invalid @enderror" id="modalidad" name="modalidad" required>
                                <option value="presencial" {{ old('modalidad') == 'presencial' ? 'selected' : '' }}>Presencial</option>
                                <option value="remoto" {{ old('modalidad') == 'remoto' ? 'selected' : '' }}>Remoto</option>
                                <option value="hibrido" {{ old('modalidad') == 'hibrido' ? 'selected' : '' }}>Híbrido</option>
                            </select>
                            @error('modalidad')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="duracion_meses" class="form-label">Duración (meses)</label>
                            <input type="number" class="form-control @error('duracion_meses') is-invalid @enderror" 
                                   id="duracion_meses" name="duracion_meses" value="{{ old('duracion_meses') }}" 
                                   min="1" max="12" step="0.5" placeholder="6">
                            @error('duracion_meses')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="num_plazas" class="form-label">Número de Plazas <span class="text-danger">*</span></label>
                            <input type="number" class="form-control @error('num_plazas') is-invalid @enderror" 
                                   id="num_plazas" name="num_plazas" value="{{ old('num_plazas', 1) }}" 
                                   min="1" max="50" required>
                            @error('num_plazas')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Beca -->
                        <div class="col-12 mb-3">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="con_beca" name="con_beca" value="1"
                                       {{ old('con_beca') ? 'checked' : '' }}>
                                <label class="form-check-label fw-semibold" for="con_beca">
                                    La vacante incluye beca económica
                                </label>
                            </div>
                        </div>

                        <div class="col-md-6 mb-3" id="monto_beca_container" style="display: none;">
                            <label for="monto_beca" class="form-label">Monto de la Beca (mensual)</label>
                            <div class="input-group">
                                <span class="input-group-text">$</span>
                                <input type="number" class="form-control @error('monto_beca') is-invalid @enderror" 
                                       id="monto_beca" name="monto_beca" value="{{ old('monto_beca') }}" 
                                       min="0" step="0.01" placeholder="0.00">
                            </div>
                            @error('monto_beca')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="fecha_inicio" class="form-label">Fecha de Inicio (opcional)</label>
                            <input type="date" class="form-control @error('fecha_inicio') is-invalid @enderror" 
                                   id="fecha_inicio" name="fecha_inicio" value="{{ old('fecha_inicio') }}">
                            @error('fecha_inicio')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="fecha_limite_postulacion" class="form-label">Fecha Límite de Postulación</label>
                            <input type="date" class="form-control @error('fecha_limite_postulacion') is-invalid @enderror" 
                                   id="fecha_limite_postulacion" name="fecha_limite_postulacion" value="{{ old('fecha_limite_postulacion') }}">
                            @error('fecha_limite_postulacion')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <a href="{{ route('vacantes.index') }}" class="btn btn-outline-secondary me-md-2">
                            <i class="bi bi-arrow-left me-1"></i> Cancelar
                        </a>
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="bi bi-send-fill me-1"></i> Enviar Vacante
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Información adicional -->
        <div class="card mt-4">
            <div class="card-body">
                <h6 class="fw-bold text-primary mb-3">
                    <i class="bi bi-info-circle-fill me-2"></i>Información Importante
                </h6>
                <ul class="mb-0">
                    <li>Tu vacante será <strong>revisada por nuestro equipo</strong> antes de ser publicada.</li>
                    <li>El proceso de revisión puede tomar entre <strong>24 a 48 horas</strong>.</li>
                    <li>Una vez aprobada, será visible para todos los estudiantes del TecNM Cuautla.</li>
                    <li>Recibirás las postulaciones directamente en tu correo electrónico.</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const conBecaCheck = document.getElementById('con_beca');
        const montoBecaContainer = document.getElementById('monto_beca_container');
        
        // Mostrar/ocultar campo de monto de beca
        function toggleMontoBeca() {
            if (conBecaCheck.checked) {
                montoBecaContainer.style.display = 'block';
                document.getElementById('monto_beca').setAttribute('required', 'required');
            } else {
                montoBecaContainer.style.display = 'none';
                document.getElementById('monto_beca').removeAttribute('required');
            }
        }
        
        // Inicializar
        toggleMontoBeca();
        
        // Evento de cambio
        conBecaCheck.addEventListener('change', toggleMontoBeca);
        
        // Validación de fechas
        const fechaInicio = document.getElementById('fecha_inicio');
        const fechaLimite = document.getElementById('fecha_limite_postulacion');
        
        fechaInicio.addEventListener('change', function() {
            if (this.value && fechaLimite.value && this.value <= fechaLimite.value) {
                fechaLimite.setCustomValidity('La fecha límite debe ser anterior a la fecha de inicio');
            } else {
                fechaLimite.setCustomValidity('');
            }
        });
    });
</script>
@endpush
