@extends('admin.layout')

@section('title', 'Ayudantes - Ramtclimatec')

@section('content')
<div class="row">
  <div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-4">
          <h4 class="card-title">Ayudantes</h4>
          <a href="{{ route('admin.ayudantes.create') }}" class="btn btn-primary">
            <i class="mdi mdi-plus"></i> Nuevo Ayudante
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
                <th>Acciones</th>
              </tr>
            </thead>
            <tbody>
              @forelse($ayudantes as $ayudante)
              <tr>
                <td>{{ $ayudante->id }}</td>
                <td>{{ $ayudante->rut ?? '-' }}</td>
                <td>{{ $ayudante->nombre }}</td>
                <td>{{ $ayudante->telefono ?? '-' }}</td>
                <td>{{ $ayudante->email ?? '-' }}</td>
                <td>
                  <a href="{{ route('admin.ayudantes.edit', $ayudante->id) }}" class="btn btn-warning btn-sm">
                    <i class="mdi mdi-pencil"></i>
                  </a>
                  <form action="{{ route('admin.ayudantes.destroy', $ayudante->id) }}" method="POST" style="display:inline;">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Eliminar?')">
                      <i class="mdi mdi-delete"></i>
                    </button>
                  </form>
                </td>
              </tr>
              @empty
              <tr><td colspan="6" class="text-center">No hay ayudantes</td></tr>
              @endforelse
            </tbody>
          </table>
        </div>
        <div class="mt-4 custom-pagination">{{ $ayudantes->links('pagination.bootstrap-custom') }}</div>
      </div>
    </div>
  </div>
</div>
@endsection