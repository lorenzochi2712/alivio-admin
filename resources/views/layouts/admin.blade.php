<!DOCTYPE html>
<html lang="es" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Panel de administración')</title>
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    <!-- Core CSS -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/core.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/theme-default.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/demo.css') }}">

    <!-- Icons -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/fonts/boxicons.css') }}">
</head>
<body>

<div class="layout-wrapper layout-content-navbar">
    <div class="layout-container">

        <!-- Sidebar -->
        <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
            <div class="app-brand demo">
                <a href="{{ route('home') }}" class="app-brand-link">
                    <span class="app-brand-text demo menu-text fw-bolder ms-2">Panel de administración</span>
                </a>
            </div>

            <ul class="menu-inner py-1">
                <li class="menu-item active">
                    <a href="{{ route('home') }}" class="menu-link">
                        <i class="menu-icon tf-icons bx bx-home-circle"></i>
                        <div>Dashboard</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="{{ route('admin.users.index') }}" class="menu-link">
                        <i class="menu-icon tf-icons bx bx-user"></i>
                        <div>Usuarios</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="{{ route('logout') }}" class="menu-link"
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="menu-icon tf-icons bx bx-log-out"></i>
                        <div>Cerrar sesión</div>
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </li>
            </ul>
        </aside>
        <!-- /Sidebar -->

        <!-- Layout page -->
        <div class="layout-page">

            <!-- Navbar -->
            <nav class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme" id="layout-navbar">
                <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">

                    <!-- Menú toggle para sidebar -->
                    <div class="navbar-nav align-items-center">
                        <a class="layout-menu-toggle navbar-nav-link px-0 me-xl-4" href="javascript:void(0)">
                            <i class="bx bx-menu bx-sm"></i>
                        </a>
                    </div>

                    <!-- Usuario -->
                    <ul class="navbar-nav flex-row align-items-center ms-auto">
                        <li class="nav-item navbar-dropdown dropdown-user dropdown">
                            <a class="nav-link dropdown-toggle hide-arrow" href="#" data-bs-toggle="dropdown">
                                <div class="avatar avatar-online">
                                    <img src="{{ asset(Auth::user()->profile_photo ?? 'assets/img/avatars/1.png') }}" class="w-px-40 h-auto rounded-circle">
                                </div>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li>
                                    <a class="dropdown-item" href="{{ route('home') }}">
                                        <div class="d-flex">
                                            <div class="flex-grow-1">
                                                <span class="fw-semibold d-block">{{ Auth::user()->name }}</span>
                                                <small class="text-muted">{{ ucfirst(Auth::user()->role) }}</small>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('profile.edit') }}">
                                    <i class="bx bx-user me-2"></i>
                                        <span class="align-middle">Mi Perfil</span>
                                     </a>
                                </li>
                                <li>
                                    <div class="dropdown-divider"></div>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        <i class="bx bx-power-off me-2"></i>
                                        <span class="align-middle">Cerrar sesión</span>
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </li>
                            </ul>
                        </li>
                    </ul>

                </div>
            </nav>
            <!-- /Navbar -->

            <!-- Content wrapper -->
            <div class="content-wrapper">
                <div class="container-xxl flex-grow-1 container-p-y">
                    @yield('content')
                </div>
            </div>

        </div>
        <!-- /Layout page -->

    </div>
</div>

<!-- Core JS -->
<script src="{{ asset('assets/vendor/libs/jquery/jquery.js') }}"></script>
<script src="{{ asset('assets/vendor/libs/popper/popper.js') }}"></script>
<script src="{{ asset('assets/vendor/js/bootstrap.js') }}"></script>
<script src="{{ asset('assets/vendor/js/menu.js') }}"></script>

<!-- Main JS -->
<script src="{{ asset('assets/js/main.js') }}"></script>
<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@yield('scripts')
</body>
</html>
