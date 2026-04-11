@extends('admin.layout')

@section('title', 'Técnicos - Ramtclimatec')

@section('content')
<div class="row">
  <div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-4">
          <h4 class="card-title">Técnicos</h4>
          <a href="{{ route('admin.tecnicos.create') }}" class="btn btn-primary">
            <i class="mdi mdi-plus"></i> Nuevo Técnico
          </a>
        </div>
        
        @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="table-responsive">
          <table class="table">
            <thead>
              <tr>
                <th>ID</th>
                <th>RUT</th>
                <th>Nombre</th>
                <th>Teléfono</th>
                <th>Email</th>
                <th>Especialidad</th>
                <th>Acciones</th>
              </tr>
            </thead>
            <tbody>
              @forelse($tecnicos as $tecnico)
              <tr>
                <td>{{ $tecnico->id }}</td>
                <td>{{ $tecnico->rut }}</td>
                <td>{{ $tecnico->nombre }}</td>
                <td>{{ $tecnico->telefono ?? '-' }}</td>
                <td>{{ $tecnico->email ?? '-' }}</td>
                <td>{{ $tecnico->especialidad ?? '-' }}</td>
                <td>
                  <a href="{{ route('admin.tecnicos.edit', $tecnico->id) }}" class="btn btn-warning btn-sm">
                    <i class="mdi mdi-pencil"></i>
                  </a>
                  <form action="{{ route('admin.tecnicos.destroy', $tecnico->id) }}" method="POST" style="display:inline;">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Eliminar?')">
                      <i class="mdi mdi-delete"></i>
                    </button>
                  </form>
                </td>
              </tr>
              @empty
              <tr><td colspan="7" class="text-center">No hay técnicos</td></tr>
              @endforelse
            </tbody>
          </table>
        </div>
        <div class="mt-4 custom-pagination">{{ $tecnicos->links('pagination.bootstrap-custom') }}</div>
      </div>
    </div>
  </div>
</div>
@endsection