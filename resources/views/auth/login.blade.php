@extends('layouts.app')

@section('title', 'Iniciar Sesión')
@section('header', 'Panel de Administración')
@section('subtitle', 'Acceso autorizado para personal del TecNM')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6 col-lg-4">
        <div class="card">
            <div class="card-body p-5">
                <div class="text-center mb-4">
                    <div class="mb-3">
                        <div class="d-flex justify-content-center gap-3 mb-3">
                            <!-- Logos placeholders -->
                            <div class="logo-placeholder-login">
                                <span>Logo_ITC</span>
                            </div>
                            <div class="logo-placeholder-login">
                                <span>Logo_TCN</span>
                            </div>
                        </div>
                        <h4 class="fw-bold text-primary">Iniciar Sesión</h4>
                        <p class="text-muted mb-0">Panel de Administración</p>
                    </div>
                </div>

                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    
                    <div class="mb-3">
                        <label for="correo" class="form-label">Correo Electrónico</label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="bi bi-envelope-fill"></i>
                            </span>
                            <input type="email" 
                                   class="form-control @error('correo') is-invalid @enderror" 
                                   id="correo" 
                                   name="correo" 
                                   value="{{ old('correo') }}" 
                                   required 
                                   autofocus
                                   placeholder="usuario@cuautla.tecnm.mx">
                            @error('correo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Contraseña</label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="bi bi-lock-fill"></i>
                            </span>
                            <input type="password" 
                                   class="form-control @error('password') is-invalid @enderror" 
                                   id="password" 
                                   name="password" 
                                   required
                                   placeholder="Tu contraseña">
                            <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                <i class="bi bi-eye-fill" id="toggleIcon"></i>
                            </button>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-4">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="remember" name="remember" 
                                   {{ old('remember') ? 'checked' : '' }}>
                            <label class="form-check-label" for="remember">
                                Recordar sesión
                            </label>
                        </div>
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="bi bi-box-arrow-in-right me-2"></i>Iniciar Sesión
                        </button>
                    </div>
                </form>

                <hr class="my-4">

                <div class="text-center">
                    <small class="text-muted">
                        <i class="bi bi-shield-check me-1"></i>
                        Acceso restringido solo para personal autorizado
                    </small>
                </div>
            </div>
        </div>

        <!-- Información de acceso por defecto (solo para desarrollo) -->
        @if(config('app.debug'))
            <div class="card mt-4">
                <div class="card-body">
                    <h6 class="fw-bold text-warning mb-3">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i>Información de Desarrollo
                    </h6>
                    <p class="mb-2"><strong>Usuario administrador por defecto:</strong></p>
                    <ul class="mb-0">
                        <li><strong>Correo:</strong> admin@cuautla.tecnm.mx</li>
                        <li><strong>Contraseña:</strong> admin123</li>
                    </ul>
                    <small class="text-muted">
                        <i class="bi bi-info-circle me-1"></i>
                        Esta información solo es visible en modo desarrollo
                    </small>
                </div>
            </div>
        @endif

        <!-- Enlaces adicionales -->
        <div class="text-center mt-4">
            <a href="{{ route('vacantes.index') }}" class="btn btn-outline-primary">
                <i class="bi bi-arrow-left me-1"></i> Volver al Portal
            </a>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .logo-placeholder-login {
        width: 60px;
        height: 60px;
        background-color: rgba(44, 82, 130, 0.1);
        border: 2px dashed rgba(44, 82, 130, 0.3);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: rgba(44, 82, 130, 0.7);
        font-size: 0.75rem;
        text-align: center;
        font-weight: 500;
    }

    .card {
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .input-group-text {
        background-color: var(--light-blue);
        border-color: var(--accent-blue);
        color: var(--primary-blue);
    }

    .btn-primary {
        background-color: var(--accent-blue);
        border-color: var(--accent-blue);
        font-weight: 500;
    }

    .btn-primary:hover {
        background-color: var(--secondary-blue);
        border-color: var(--secondary-blue);
    }

    @media (max-width: 768px) {
        .logo-placeholder-login {
            width: 50px;
            height: 50px;
            font-size: 0.65rem;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Toggle password visibility
        const togglePassword = document.getElementById('togglePassword');
        const passwordInput = document.getElementById('password');
        const toggleIcon = document.getElementById('toggleIcon');

        togglePassword.addEventListener('click', function() {
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            
            if (type === 'text') {
                toggleIcon.classList.remove('bi-eye-fill');
                toggleIcon.classList.add('bi-eye-slash-fill');
            } else {
                toggleIcon.classList.remove('bi-eye-slash-fill');
                toggleIcon.classList.add('bi-eye-fill');
            }
        });

        // Focus management
        const correoInput = document.getElementById('correo');
        correoInput.focus();

        // Enter key navigation
        correoInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                passwordInput.focus();
            }
        });
    });
</script>
@endpush
