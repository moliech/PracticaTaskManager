<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Manager - @yield('titulo', 'Panel de Control')</title>
    
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        body { 
            background-color: #c4d2f7; 
        }
        .sidebar { 
            min-height: 100vh; 
            background: #4e73df; 
            background: linear-gradient(180deg, #4e73df 10%, #224abe 100%); 
        }
        .sidebar .nav-link { 
            color: rgba(255,255,255,0.8); 
        }
        .sidebar .nav-link:hover { 
            color: white; 
        }
        .sidebar .nav-link.active { 
            font-weight: bold; 
            color: white; 
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <nav class="col-md-2 d-md-block sidebar p-0">
                <div class="position-sticky pt-3">
                    <h5 class="text-center text-white py-3 border-bottom border-light">📋 Task Manager</h5>
                    <ul class="nav flex-column gap-2 mt-2">
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                                <i class="fas fa-chart-line me-2"></i> Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('tasks.*') ? 'active' : '' }}" href="{{ route('tasks.index') }}">
                                <i class="fas fa-tasks me-2"></i> Mis Tareas
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('profile.*') ? 'active' : '' }}" href="{{ route('profile.edit') }}">
                                <i class="fas fa-user-cog me-2"></i> Mi Perfil
                            </a>
                        </li>
                        <li class="nav-item border-top border-light mt-3 pt-3">
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                            <a class="nav-link text-warning fw-bold" href="{{ route('logout') }}"
                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="fas fa-sign-out-alt me-2"></i> Cerrar Sesión
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>

            <main class="col-md-10 ms-sm-auto px-md-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">
                        @if(isset($header))
                            {{ $header }}
                        @else
                            @yield('header', 'Panel')
                        @endif
                    </h1>
                    <span class="badge bg-primary px-3 py-2 fs-6 shadow-sm">
                        <i class="fas fa-user me-2"></i>{{ Auth::user()->name ?? 'Bienvenido' }}
                    </span>
                </div>

                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if(isset($slot))
                    {{ $slot }}
                @else
                    @yield('content')
                @endif
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>