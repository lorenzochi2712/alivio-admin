@extends('layouts.admin')

@section('title', 'Usuarios')

@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Lista de usuarios</h5>
    </div>
    <div class="table-responsive">
        <table class="table table-striped mb-0">
            <thead>
                <tr>
                    <th>UID</th>
                    <th>Correo</th>
                    <th>Nombre</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                    <tr>
                        <td>{{ $user['uid'] }}</td>
                        <td>{{ $user['email'] }}</td>
                        <td>{{ $user['name'] }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="text-center">No hay usuarios registrados</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
