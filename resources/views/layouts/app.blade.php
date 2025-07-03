<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Dashboard') - MP Jember</title>

    <!-- Favicon -->
    <link rel="icon" type="image/svg+xml" href="{{ asset('assets/images/logo.svg') }}">
    <link rel="shortcut icon" type="image/svg+xml" href="{{ asset('assets/images/logo.svg') }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Custom CSS -->
    <style>
        .sidebar {
            min-height: 100vh;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        .sidebar .nav-link {
            color: rgba(255, 255, 255, 0.8);
            padding: 0.75rem 1rem;
            margin: 0.25rem 0;
            border-radius: 0.5rem;
            transition: all 0.3s ease;
        }
        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            color: white;
            background-color: rgba(255, 255, 255, 0.1);
        }
        .main-content {
            background-color: #f8f9fa;
            min-height: 100vh;
        }
        .card {
            border: none;
            border-radius: 1rem;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        }
        .card-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 1rem 1rem 0 0 !important;
        }
        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
        }
        .btn-primary:hover {
            background: linear-gradient(135deg, #5a6fd8 0%, #6a4190 100%);
        }
    </style>

    @stack('styles')
</head>
<body>
    <div id="app">
        @auth
            <div class="container-fluid">
                <div class="row">
                    <!-- Sidebar -->
                    <nav class="col-md-3 col-lg-2 d-md-block sidebar collapse">
                        <div class="position-sticky pt-3">
                            <div class="text-center mb-4">
                                <div class="mb-3">
                                    <img src="{{ asset('assets/images/logo.svg') }}" alt="MP Jember Logo" style="width: 60px; height: 60px; object-fit: contain;">
                                </div>
                                <h4 class="text-white">MP Jember</h4>
                                <small class="text-white-50">PPS Betako Merpati Putih</small>
                            </div>
                            
                            <ul class="nav flex-column">
                                @if(auth()->user()->hasRole('admin'))
                                    <li class="nav-item">
                                        <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                                            <i class="fas fa-tachometer-alt me-2"></i>
                                            Dashboard
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}" href="{{ route('admin.users.index') }}">
                                            <i class="fas fa-users me-2"></i>
                                            Manajemen User
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link {{ request()->routeIs('admin.locations.*') ? 'active' : '' }}" href="{{ route('admin.locations.index') }}">
                                            <i class="fas fa-map-marker-alt me-2"></i>
                                            Lokasi
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link {{ request()->routeIs('admin.members.*') ? 'active' : '' }}" href="{{ route('admin.members.index') }}">
                                            <i class="fas fa-user-graduate me-2"></i>
                                            Anggota
                                        </a>
                                    </li>

                                @elseif(auth()->user()->hasRole('pelatih'))
                                    <li class="nav-item">
                                        <a class="nav-link {{ request()->routeIs('pelatih.dashboard') ? 'active' : '' }}" href="{{ route('pelatih.dashboard') }}">
                                            <i class="fas fa-tachometer-alt me-2"></i>
                                            Dashboard
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link {{ request()->routeIs('attendance.*') ? 'active' : '' }}" href="{{ route('attendance.index') }}">
                                            <i class="fas fa-clipboard-check me-2"></i>
                                            Absensi
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link {{ request()->routeIs('spp.*') ? 'active' : '' }}" href="{{ route('spp.index') }}">
                                            <i class="fas fa-money-bill me-2"></i>
                                            SPP
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link {{ request()->routeIs('shop.*') ? 'active' : '' }}" href="{{ route('shop.index') }}">
                                            <i class="fas fa-shopping-cart me-2"></i>
                                            Toko
                                        </a>
                                    </li>
                                @elseif(auth()->user()->hasRole('anggota'))
                                    <li class="nav-item">
                                        <a class="nav-link {{ request()->routeIs('anggota.dashboard') ? 'active' : '' }}" href="{{ route('anggota.dashboard') }}">
                                            <i class="fas fa-tachometer-alt me-2"></i>
                                            Dashboard
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link {{ request()->routeIs('cooperative.*') ? 'active' : '' }}" href="{{ route('cooperative.index') }}">
                                            <i class="fas fa-handshake me-2"></i>
                                            Koperasi
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link {{ request()->routeIs('shop.*') ? 'active' : '' }}" href="{{ route('shop.index') }}">
                                            <i class="fas fa-shopping-cart me-2"></i>
                                            Toko
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link {{ request()->routeIs('spp.*') ? 'active' : '' }}" href="{{ route('spp.index') }}">
                                            <i class="fas fa-money-bill me-2"></i>
                                            SPP Saya
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link {{ request()->routeIs('attendance.*') ? 'active' : '' }}" href="{{ route('attendance.index') }}">
                                            <i class="fas fa-clipboard-check me-2"></i>
                                            Absensi Saya
                                        </a>
                                    </li>
                                @endif
                                
                                <li class="nav-item mt-3">
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="nav-link border-0 bg-transparent w-100 text-start">
                                            <i class="fas fa-sign-out-alt me-2"></i>
                                            Logout
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </nav>

                    <!-- Main content -->
                    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 main-content">
                        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                            <h1 class="h2">@yield('title', 'Dashboard')</h1>
                            <div class="btn-toolbar mb-2 mb-md-0">
                                <div class="btn-group me-2">
                                    <span class="text-muted">{{ auth()->user()->name }} ({{ auth()->user()->role->display_name }})</span>
                                </div>
                            </div>
                        </div>

                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        @if(session('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                {{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        @yield('content')
                    </main>
                </div>
            </div>
        @else
            @yield('content')
        @endauth
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    @stack('scripts')
</body>
</html>
