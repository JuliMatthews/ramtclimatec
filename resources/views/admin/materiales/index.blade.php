@extends('admin.layout')

@section('title', 'Materiales - Ramtclimatec')

@section('content')
<div class="row">
  <div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-4">
          <h4 class="card-title">Materiales</h4>
          <a href="{{ route('admin.materiales.create') }}" class="btn btn-primary">
            <i class="mdi mdi-plus"></i> Nuevo Material
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
                <th>Nombre</th>
                <th>Tipo</th>
                <th>Unidad</th>
                <th>Stock</th>
                <th>Acciones</th>
              </tr>
            </thead>
            <tbody>
              @forelse($materiales as $material)
              <tr>
                <td>{{ $material->id }}</td>
                <td>{{ $material->nombre }}</td>
                <td>{{ $material->tipo ?? '-' }}</td>
                <td>{{ $material->unidad ?? '-' }}</td>
                <td>{{ $material->stock ?? 0 }}</td>
                <td>
                  <a href="{{ route('admin.materiales.edit', $material->id) }}" class="btn btn-warning btn-sm">
                    <i class="mdi mdi-pencil"></i>
                  </a>
                  <form action="{{ route('admin.materiales.destroy', $material->id) }}" method="POST" style="display:inline;">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Eliminar?')">
                      <i class="mdi mdi-delete"></i>
                    </button>
                  </form>
                </td>
              </tr>
              @empty
              <tr><td colspan="6" class="text-center">No hay materiales</td></tr>
              @endforelse
            </tbody>
          </table>
        </div>
        <div class="mt-4 custom-pagination">{{ $materiales->links('pagination.bootstrap-custom') }}</div>
      </div>
    </div>
  </div>
</div>
@endsection