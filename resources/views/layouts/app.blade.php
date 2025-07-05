<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Portal de Vacantes') - Instituto Tecnológico de Cuautla</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --primary-blue: #2c5282;
            --secondary-blue: #2a4365;
            --accent-blue: #3182ce;
            --light-blue: #bee3f8;
            --text-dark: #1a202c;
            --text-light: #4a5568;
            --bg-light: #f7fafc;
            --white: #ffffff;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--bg-light);
            color: var(--text-dark);
        }

        .navbar-brand {
            font-weight: 600;
            font-size: 1.1rem;
        }

        .header-gradient {
            background: linear-gradient(135deg, var(--primary-blue) 0%, var(--secondary-blue) 100%);
            color: white;
            padding: 2rem 0;
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

        .card {
            border: none;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.15);
        }

        .vacante-card {
            border-left: 4px solid var(--accent-blue);
        }

        .badge-servicio {
            background-color: #38a169;
        }

        .badge-residencia {
            background-color: #3182ce;
        }

        .footer {
            background-color: var(--secondary-blue);
            color: white;
            padding: 2rem 0;
            margin-top: 3rem;
        }

        .logo-container {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .logo-placeholder {
            width: 50px;
            height: 50px;
            background-color: rgba(255,255,255,0.1);
            border: 2px dashed rgba(255,255,255,0.3);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: rgba(255,255,255,0.7);
            font-size: 0.8rem;
            text-align: center;
        }

        .stats-card {
            background: linear-gradient(135deg, var(--accent-blue), var(--primary-blue));
            color: white;
            border-radius: 12px;
        }

        .filter-section {
            background: white;
            border-radius: 12px;
            padding: 1.5rem;
            margin-bottom: 2rem;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        @media (max-width: 768px) {
            .header-gradient {
                padding: 1.5rem 0;
            }
            
            .logo-container {
                justify-content: center;
                margin-bottom: 1rem;
            }
        }
    </style>

    @stack('styles')
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark" style="background-color: var(--primary-blue)">
        <div class="container">
            <div class="logo-container">
                <!-- Logo ITC -->
                <img src="{{ asset('images/Logo_ITC.png') }}" alt="Logo Instituto Tecnológico de Cuautla" 
                     style="width: 50px; height: 50px; object-fit: contain;">
                
                <a class="navbar-brand" href="{{ route('vacantes.index') }}">
                    Portal de Vacantes<br>
                    <small class="d-block" style="font-size: 0.8rem; font-weight: 400;">Instituto Tecnológico de Cuautla</small>
                </a>
                
                <!-- Logo TecNM -->
                <img src="{{ asset('images/Logo_TCN.png') }}" alt="Logo TecNM" 
                     style="width: 50px; height: 50px; object-fit: contain;">
            </div>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('vacantes.index') }}">
                            <i class="bi bi-briefcase-fill me-1"></i> Vacantes
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('vacantes.create') }}">
                            <i class="bi bi-plus-circle-fill me-1"></i> Publicar Vacante
                        </a>
                    </li>
                    @auth
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                <i class="bi bi-person-circle me-1"></i> {{ Auth::user()->nombre }}
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="{{ route('admin.dashboard') }}">Panel Admin</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}" class="d-inline">
                                        @csrf
                                        <button type="submit" class="dropdown-item">Cerrar Sesión</button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <!-- Header -->
    @if(!Request::is('vacantes/admin*'))
    <div class="header-gradient">
        <div class="container text-center">
            <h1 class="display-5 fw-bold mb-3">@yield('header', 'Portal de Vacantes')</h1>
            <p class="lead mb-0">@yield('subtitle', 'Encuentra las mejores oportunidades de Servicio Social y Residencias Profesionales')</p>
        </div>
    </div>
    @endif

    <!-- Main Content -->
    <main class="container my-4">
        <!-- Alerts -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i>
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="footer mt-auto">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <h5 class="fw-bold mb-3">Instituto Tecnológico de Cuautla</h5>
                    <p class="mb-2">Portal oficial de vacantes para Servicio Social y Residencias Profesionales</p>
                    <p class="mb-0">
                        <i class="bi bi-envelope me-2"></i> bolsatrabajo@cuautla.tecnm.mx<br>
                        <i class="bi bi-telephone me-2"></i> (735) 394 4034
                    </p>
                </div>
                <div class="col-lg-6 text-lg-end">
                    <h6 class="fw-bold mb-3">Enlaces Rápidos</h6>
                    <div class="d-flex flex-column flex-lg-row justify-content-lg-end gap-3">
                        <a href="{{ route('vacantes.index') }}" class="text-white text-decoration-none">Ver Vacantes</a>
                        <a href="{{ route('vacantes.create') }}" class="text-white text-decoration-none">Publicar Vacante</a>
                        <a href="{{ route('login') }}" class="text-white text-decoration-none">Panel Admin</a>
                    </div>
                </div>
            </div>
            <hr class="my-4" style="border-color: rgba(255,255,255,0.2)">
            <div class="text-center">
                <small>&copy; {{ date('Y') }} Instituto Tecnológico de Cuautla - TecNM. Todos los derechos reservados.</small>
            </div>
        </div>
    </footer>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    @stack('scripts')
</body>
</html>
