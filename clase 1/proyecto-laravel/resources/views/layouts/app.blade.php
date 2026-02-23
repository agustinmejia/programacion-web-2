<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'GestiEstudiantes')</title>

    {{-- Bootstrap 5 --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    {{-- Bootstrap Icons --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        :root { --bs-primary: #1e3a5f; }
        body  { background-color: #f0f4f8; }

        .navbar {
            background: linear-gradient(135deg, #1e3a5f, #2d6a9f) !important;
        }
        .navbar-brand { font-weight: 700; }
        .navbar .nav-link        { color: rgba(255,255,255,.85) !important; }
        .navbar .nav-link:hover,
        .navbar .nav-link.active { color: #fff !important; }

        .card         { border: none; border-radius: .75rem; box-shadow: 0 2px 12px rgba(0,0,0,.08); }
        .card-header  {
            background: linear-gradient(135deg, #1e3a5f, #2d6a9f);
            color: #fff; border-radius: .75rem .75rem 0 0 !important; font-weight: 600;
        }
        .btn-primary  { background: linear-gradient(135deg, #1e3a5f, #2d6a9f); border: none; }
        .btn-primary:hover { opacity: .88; }
        .table thead th { background-color: #e8eef5; font-weight: 600; }
        footer { font-size: .8rem; color: #aaa; }
    </style>

    @stack('styles')
</head>
<body>

{{-- Navbar --}}
<nav class="navbar navbar-expand-lg shadow-sm mb-4">
    <div class="container">
        <a class="navbar-brand text-white" href="{{ route('estudiantes.index') }}">
            <i class="bi bi-mortarboard-fill me-2"></i>GestiEstudiantes
        </a>

        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navMenu">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('estudiantes.index') ? 'active fw-semibold' : '' }}"
                       href="{{ route('estudiantes.index') }}">
                        <i class="bi bi-people"></i> Estudiantes
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('estudiantes.create') ? 'active fw-semibold' : '' }}"
                       href="{{ route('estudiantes.create') }}">
                        <i class="bi bi-person-plus"></i> Nuevo estudiante
                    </a>
                </li>
            </ul>

            <ul class="navbar-nav">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle d-flex align-items-center gap-2" href="#" data-bs-toggle="dropdown">
                        <i class="bi bi-person-circle fs-5"></i>
                        <span>{{ Auth::user()->name ?? 'Usuario' }}</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end shadow">
                        <li>
                            <span class="dropdown-item-text text-muted small">
                                {{ Auth::user()->email ?? '' }}
                            </span>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item text-danger">
                                    <i class="bi bi-box-arrow-right me-1"></i> Cerrar sesión
                                </button>
                            </form>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>

{{-- Contenido principal --}}
<main class="container pb-5">
    @yield('content')
</main>

<footer class="text-center py-4 mt-3">
    <p class="mb-0">GestiEstudiantes &copy; {{ date('Y') }} — Sistema de gestión escolar</p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>
