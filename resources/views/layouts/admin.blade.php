<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Panel de Administración') - Portal de Vacantes</title>
    
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
            --sidebar-bg: #2d3748;
            --sidebar-hover: #4a5568;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--bg-light);
            color: var(--text-dark);
        }

        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            width: 250px;
            background-color: var(--sidebar-bg);
            color: white;
            transition: transform 0.3s ease;
            z-index: 1000;
        }

        .sidebar-header {
            padding: 1.5rem;
            border-bottom: 1px solid rgba(255,255,255,0.1);
            background-color: var(--primary-blue);
        }

        .sidebar-nav {
            padding: 1rem 0;
        }

        .sidebar-nav .nav-link {
            color: rgba(255,255,255,0.8);
            padding: 0.75rem 1.5rem;
            border: none;
            transition: all 0.2s ease;
        }

        .sidebar-nav .nav-link:hover,
        .sidebar-nav .nav-link.active {
            color: white;
            background-color: var(--sidebar-hover);
        }

        .sidebar-nav .nav-link i {
            width: 20px;
            margin-right: 0.75rem;
        }

        .main-content {
            margin-left: 250px;
            min-height: 100vh;
            transition: margin-left 0.3s ease;
        }

        .navbar-admin {
            background-color: white;
            border-bottom: 1px solid #e2e8f0;
            padding: 1rem 2rem;
        }

        .content-wrapper {
            padding: 2rem;
        }

        .stats-card {
            background: linear-gradient(135deg, var(--accent-blue), var(--primary-blue));
            color: white;
            border-radius: 12px;
            border: none;
        }

        .stats-card .card-body {
            padding: 1.5rem;
        }

        .stats-number {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        .card {
            border: none;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            border-radius: 12px;
        }

        .table {
            border-radius: 12px;
            overflow: hidden;
        }

        .badge {
            font-size: 0.75rem;
            padding: 0.5rem 0.75rem;
        }

        .btn-action {
            padding: 0.25rem 0.5rem;
            font-size: 0.875rem;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }
            
            .sidebar.show {
                transform: translateX(0);
            }
            
            .main-content {
                margin-left: 0;
            }
            
            .content-wrapper {
                padding: 1rem;
            }
        }

        .logo-container {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .logo-placeholder {
            width: 35px;
            height: 35px;
            background-color: rgba(255,255,255,0.1);
            border: 2px dashed rgba(255,255,255,0.3);
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: rgba(255,255,255,0.7);
            font-size: 0.65rem;
            text-align: center;
        }
    </style>

    @stack('styles')
</head>
<body>
    <!-- Sidebar -->
    <nav class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <div class="logo-container">
                <div class="logo-placeholder">
                    <span>ITC</span>
                </div>
                <div>
                    <h6 class="mb-0 fw-bold">Panel Admin</h6>
                    <small class="text-light opacity-75">Portal de Vacantes</small>
                </div>
                <div class="logo-placeholder">
                    <span>TCN</span>
                </div>
            </div>
        </div>

        <div class="sidebar-nav">
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link {{ Request::routeIs('admin.dashboard') ? 'active' : '' }}" 
                       href="{{ route('admin.dashboard') }}">
                        <i class="bi bi-speedometer2"></i>Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Request::routeIs('admin.vacantes*') ? 'active' : '' }}" 
                       href="{{ route('admin.vacantes') }}">
                        <i class="bi bi-briefcase"></i>Gestión de Vacantes
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Request::routeIs('admin.postulaciones*') ? 'active' : '' }}" 
                       href="{{ route('admin.postulaciones') }}">
                        <i class="bi bi-people"></i>Postulaciones
                    </a>
                </li>
                @if(Auth::user()->isAdmin())
                    <li class="nav-item">
                        <a class="nav-link {{ Request::routeIs('admin.usuarios*') ? 'active' : '' }}" 
                           href="{{ route('admin.usuarios') }}">
                            <i class="bi bi-person-gear"></i>Usuarios
                        </a>
                    </li>
                @endif
                <li class="nav-item mt-3">
                    <hr class="text-light opacity-25 mx-3">
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('vacantes.index') }}" target="_blank">
                        <i class="bi bi-box-arrow-up-right"></i>Ver Portal Público
                    </a>
                </li>
                <li class="nav-item">
                    <form method="POST" action="{{ route('logout') }}" class="d-inline w-100">
                        @csrf
                        <button type="submit" class="nav-link border-0 bg-transparent w-100 text-start">
                            <i class="bi bi-box-arrow-right"></i>Cerrar Sesión
                        </button>
                    </form>
                </li>
            </ul>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Top Navbar -->
        <nav class="navbar-admin d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center">
                <button class="btn btn-outline-secondary d-md-none me-3" id="sidebarToggle">
                    <i class="bi bi-list"></i>
                </button>
                <div>
                    <h5 class="mb-0 fw-bold">@yield('page-title', 'Panel de Administración')</h5>
                    <small class="text-muted">@yield('page-subtitle', 'Gestión del Portal de Vacantes')</small>
                </div>
            </div>
            
            <div class="d-flex align-items-center gap-3">
                <span class="text-muted">
                    <i class="bi bi-person-circle me-1"></i>
                    {{ Auth::user()->nombre }}
                    <span class="badge bg-primary ms-1">{{ Auth::user()->rol_texto }}</span>
                </span>
            </div>
        </nav>

        <!-- Content -->
        <div class="content-wrapper">
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
        </div>
    </div>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Sidebar toggle for mobile
        document.addEventListener('DOMContentLoaded', function() {
            const sidebarToggle = document.getElementById('sidebarToggle');
            const sidebar = document.getElementById('sidebar');
            
            if (sidebarToggle) {
                sidebarToggle.addEventListener('click', function() {
                    sidebar.classList.toggle('show');
                });
            }

            // Auto-hide alerts after 5 seconds
            const alerts = document.querySelectorAll('.alert[role="alert"]');
            alerts.forEach(alert => {
                if (!alert.classList.contains('alert-permanent')) {
                    setTimeout(() => {
                        const bsAlert = new bootstrap.Alert(alert);
                        bsAlert.close();
                    }, 5000);
                }
            });
        });
    </script>
    
    @stack('scripts')
</body>
</html>
