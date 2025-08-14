@extends('layouts.admin')

@section('content')
<div class="container">
    <h1>Editar perfil</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label>Nombre</label>
            <input type="text" name="name" value="{{ old('name', $user->name) }}" class="form-control">
        </div>

        <div class="mb-3">
            <label>Correo electrónico</label>
            <input type="email" name="email" value="{{ old('email', $user->email) }}" class="form-control">
        </div>

        <div class="mb-3">
            <label>Contraseña (opcional)</label>
            <input type="password" name="password" class="form-control">
            <input type="password" name="password_confirmation" placeholder="Confirmar contraseña" class="form-control mt-2">
        </div>

        <div class="mb-3">
            <label>Foto de perfil</label>
            <input type="file" name="profile_photo" class="form-control">
            @if($user->profile_photo)
                <div class="mt-2">
                    <img src="{{ asset($user->profile_photo) }}" width="100" class="rounded-circle">
                </div>
            @endif
        </div>

        <button type="submit" class="btn btn-primary">Actualizar perfil</button>
    </form>
</div>
@endsection
