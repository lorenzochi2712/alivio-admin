@extends('layouts.admin')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="card">
        <div class="card-header">
            <h5>Editar Usuario</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('users.update', $user['uid']) }}" method="POST">
                @csrf
                @method('PATCH')

                <div class="mb-3">
                    <label for="uid" class="form-label">UID</label>
                    <input type="text" class="form-control" id="uid" value="{{ $user['uid'] }}" disabled>
                </div>

                <div class="mb-3">
                    <label for="nombre" class="form-label">Nombre</label>
                    <input type="text" class="form-control" id="nombre" name="nombre" value="{{ $user['nombre'] }}" required>
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Correo Electrónico</label>
                    <input type="email" class="form-control" id="email" name="email" value="{{ $user['email'] }}" required>
                </div>

                <button type="submit" class="btn btn-primary">
                    <i class="bx bx-save"></i> Guardar cambios
                </button>
                <a href="{{ route('users.index') }}" class="btn btn-secondary">Cancelar</a>
            </form>
        </div>
    </div>
</div>
@endsection
