@extends('admin.layout')

@section('title', 'Clientes - Ramtclimatec')

@section('content')
<div class="row">
  <div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-4">
          <h4 class="card-title">Clientes</h4>
          <a href="{{ route('admin.clientes.create') }}" class="btn btn-primary">
            <i class="mdi mdi-plus"></i> Nuevo Cliente
          </a>
        </div>
        
        @if(session('success'))
        <div class="alert alert-success">
          {{ session('success') }}
        </div>
        @endif

        <div class="table-responsive">
          <table class="table">
            <thead>
              <tr>
                <th>Tipo</th>
                <th>Cliente</th>
                <th>Región</th>
                <th>Comuna</th>
                <th>Correo</th>
                <th>Teléfono</th>
                <th>Equipos</th>
                <th>Activo</th>
                <th>Creado</th>
                <th>Acciones</th>
              </tr>
            </thead>
            <tbody>
              @forelse($clientes as $cliente)
              <tr>
                <td>{{ $cliente->tipo ?? 'Empresa' }}</td>
                <td>{{ $cliente->nombre }}</td>
                <td>{{ $cliente->direcciones->first()->region ?? '-' }}</td>
                <td>{{ $cliente->direcciones->first()->comuna ?? '-' }}</td>
                <td>{{ $cliente->email ?? '-' }}</td>
                <td>{{ $cliente->telefono ?? '-' }}</td>
                <td>
                  <span class="badge badge-info">{{ $cliente->equipos->count() }}</span>
                </td>
                <td>
                  @if($cliente->activo)
                    <span class="badge badge-success">Activo</span>
                  @else
                    <span class="badge badge-secondary">Inactivo</span>
                  @endif
                </td>
                <td>{{ $cliente->created_at->format('d-m-Y') }}</td>
                <td>
                  <a href="{{ route('admin.clientes.edit', $cliente->id) }}" class="btn btn-warning btn-sm">
                    <i class="mdi mdi-pencil"></i>
                  </a>
                  <form action="{{ route('admin.clientes.destroy', $cliente->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Eliminar este cliente?')">
                      <i class="mdi mdi-delete"></i>
                    </button>
                  </form>
                </td>
              </tr>
              @empty
              <tr>
                <td colspan="10" class="text-center">No hay clientes registrados</td>
              </tr>
              @endforelse
            </tbody>
          </table>
        </div>
        
        <div class="mt-4">
          <div class="mt-4 custom-pagination">{{ $clientes->links('pagination.bootstrap-custom') }}</div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection