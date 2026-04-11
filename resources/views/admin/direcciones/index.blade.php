@extends('admin.layout')

@section('title', 'Direcciones - Ramtclimatec')

@section('content')
<div class="row">
  <div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-4">
          <h4 class="card-title">Direcciones</h4>
          <a href="{{ route('admin.direcciones.create') }}" class="btn btn-primary">
            <i class="mdi mdi-plus"></i> Nueva Dirección
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
                <th>Cliente</th>
                <th>Dirección</th>
                <th>Comuna</th>
                <th>Teléfono</th>
                <th>Acciones</th>
              </tr>
            </thead>
            <tbody>
              @forelse($direcciones as $direccion)
              <tr>
                <td>{{ $direccion->id }}</td>
                <td>{{ $direccion->cliente->nombre ?? 'Sin cliente' }}</td>
                <td>
                  {{ $direccion->calle }}
                  @if($direccion->numero){{ ' ' . $direccion->numero }}@endif
                  @if($direccion->depto), {{ $direccion->depto }}@endif
                </td>
                <td>{{ $direccion->comuna ?? '-' }}</td>
                <td>{{ $direccion->telefono ?? '-' }}</td>
                <td>
                  <a href="{{ route('admin.direcciones.show', $direccion->id) }}" class="btn btn-info btn-sm">
                    <i class="mdi mdi-eye"></i>
                  </a>
                  <a href="{{ route('admin.direcciones.edit', $direccion->id) }}" class="btn btn-warning btn-sm">
                    <i class="mdi mdi-pencil"></i>
                  </a>
                  <form action="{{ route('admin.direcciones.destroy', $direccion->id) }}" method="POST" style="display:inline;">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Eliminar?')">
                      <i class="mdi mdi-delete"></i>
                    </button>
                  </form>
                </td>
              </tr>
              @empty
              <tr><td colspan="6" class="text-center">No hay direcciones</td></tr>
              @endforelse
            </tbody>
          </table>
        </div>
        <div class="mt-4 custom-pagination">{{ $direcciones->links('pagination.bootstrap-custom') }}</div>
      </div>
    </div>
  </div>
</div>
@endsection