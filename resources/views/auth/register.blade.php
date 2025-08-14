<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro - Alivio Admin</title>
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">

    <!-- Fonts -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/fonts/boxicons.css') }}">

    <!-- Core CSS -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/core.css') }}" class="template-customizer-core-css">
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/theme-default.css') }}" class="template-customizer-theme-css">
    <link rel="stylesheet" href="{{ asset('assets/css/demo.css') }}">

    <!-- Page CSS -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/pages/page-auth.css') }}">

    <!-- Helpers -->
    <script src="{{ asset('assets/vendor/js/helpers.js') }}"></script>

    <!-- Config -->
    <script src="{{ asset('assets/js/config.js') }}"></script>
</head>
<body>

<div class="container-xxl">
    <div class="authentication-wrapper authentication-basic container-p-y">
        <div class="authentication-inner">

            <div class="card">
                <div class="card-body">

                    <h4 class="mb-2">Crear una cuenta de administrador</h4>
                    <p class="mb-4">Registra un nuevo usuario para Panel de administración</p>

                    <form method="POST" action="{{ route('register.post') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="name" class="form-label">Nombre</label>
                            <input type="text" class="form-control" name="name" value="{{ old('name') }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Correo electrónico</label>
                            <input type="email" class="form-control" name="email" value="{{ old('email') }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="role" class="form-label">Tipo de usuario</label>
                            <select name="role" class="form-control" required>
                                <option value="">Seleccione...</option>
                                <option value="administrador">Administrador</option>
                                <option value="secretaria">Secretaria</option>
                            </select>
                        </div>

                        <div class="mb-3 form-password-toggle">
                            <label class="form-label" for="password">Contraseña</label>
                            <input type="password" class="form-control" name="password" required>
                        </div>

                        <div class="mb-3 form-password-toggle">
                            <label class="form-label" for="password_confirmation">Confirmar contraseña</label>
                            <input type="password" class="form-control" name="password_confirmation" required>
                        </div>

                        <button class="btn btn-primary d-grid w-100">Registrarse</button>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>

<script src="{{ asset('assets/vendor/js/core.js') }}"></script>
<script src="{{ asset('assets/vendor/js/menu.js') }}"></script>
</body>
</html>
