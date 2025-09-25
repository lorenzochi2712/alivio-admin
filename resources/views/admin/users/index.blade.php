@extends('layouts.admin') {{-- Ajusta según tu layout Sneat --}}

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="fw-bold">Usuarios de Aliiivio</h4>
        <!-- Barra de búsqueda en vivo -->
        <div class="w-25">
            <input type="text" id="search" class="form-control" placeholder="Buscar por nombre...">
        </div>
    </div>

    <!-- Tabla -->
    <div class="card">
        <div class="table-responsive text-nowrap">
            <table class="table table-striped table-hover text-center align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>UID</th>
                        <th>Nombre</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody id="userTable">
                    @foreach ($users as $user)
                        <tr>
                            <td><span class="badge bg-primary">{{ $user['uid'] }}</span></td>
                            <td>{{ $user['nombre'] }}</td>
                            <td>
                                <a href="{{ route('users.edit', $user['uid']) }}" class="btn btn-sm btn-warning">
                                    <i class="bx bx-edit"></i> Editar
                                </a>
                                <form action="{{ route('users.destroy', $user['uid']) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Seguro que deseas eliminar este usuario?')">
                                        <i class="bx bx-trash"></i> Eliminar
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- 🔹 Paginación estilo Bootstrap 5 -->
        @if ($users->lastPage() > 1)
            <div class="d-flex justify-content-center my-3">
                <ul class="pagination pagination-sm">
                    {{-- Botón anterior --}}
                    <li class="page-item {{ $users->onFirstPage() ? 'disabled' : '' }}">
                        <a class="page-link" href="{{ $users->previousPageUrl() }}" aria-label="Anterior">
                            <i class="bx bx-chevron-left"></i>
                        </a>
                    </li>

                    {{-- Números de página --}}
                    @for ($i = 1; $i <= $users->lastPage(); $i++)
                        <li class="page-item {{ $i == $users->currentPage() ? 'active' : '' }}">
                            <a class="page-link" href="{{ $users->url($i) }}">{{ $i }}</a>
                        </li>
                    @endfor

                    {{-- Botón siguiente --}}
                    <li class="page-item {{ $users->currentPage() == $users->lastPage() ? 'disabled' : '' }}">
                        <a class="page-link" href="{{ $users->nextPageUrl() }}" aria-label="Siguiente">
                            <i class="bx bx-chevron-right"></i>
                        </a>
                    </li>
                </ul>
            </div>
        @endif
    </div>
</div>
@endsection

@section('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function(){
    $('#search').on('keyup', function(){
        let query = $(this).val();

        $.ajax({
            url: "{{ route('admin.users.index') }}", // Asegúrate de que esta ruta exista
            method: 'GET',
            data: { search: query },
            success: function(data){
                let rows = '';
                if(data.length > 0){
                    data.forEach(user => {
                        rows += `
                            <tr>
                                <td><span class="badge bg-primary">${user.uid}</span></td>
                                <td>${user.nombre}</td>
                                <td>
                                    <a href="/users/${user.uid}/edit" class="btn btn-sm btn-warning">
                                        <i class="bx bx-edit"></i> Editar
                                    </a>
                                    <form action="/users/${user.uid}" method="POST" class="d-inline deleteForm">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Seguro que deseas eliminar este usuario?')">
                                            <i class="bx bx-trash"></i> Eliminar
                                        </button>
                                    </form>
                                </td>
                            </tr>`;
                    });
                } else {
                    rows = `<tr><td colspan="3" class="text-center text-muted">No se encontraron usuarios</td></tr>`;
                }
                $('#userTable').html(rows);
            }
        });
    });
});
</script>
@endsection
