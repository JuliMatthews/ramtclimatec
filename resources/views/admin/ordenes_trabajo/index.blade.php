@extends('admin.layout')

@section('title', 'Órdenes de Trabajo - Ramtclimatec')

@section('content')
<div class="row">
  <div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-4">
          <h4 class="card-title">Órdenes de Trabajo</h4>
          <a href="{{ route('admin.ordenes_trabajo.create') }}" class="btn btn-primary">
            <i class="mdi mdi-plus"></i> Nueva Orden
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
                <th>ID</th>
                <th>Cliente</th>
                <th>Tipo de Servicio</th>
                <th>Estado</th>
                <th>Fecha Inicio</th>
                <th>Acciones</th>
              </tr>
            </thead>
            <tbody>
              @forelse($ordenes as $orden)
              <tr>
                <td>#{{ $orden->id }}</td>
                <td>{{ $orden->cliente->nombre ?? 'Sin cliente' }}</td>
                <td>{{ $orden->tipo_servicio }}</td>
                <td>
                  @switch($orden->estado)
                    @case('pendiente')
                      <span class="badge badge-warning">Pendiente</span>
                      @break
                    @case('en_proceso')
                      <span class="badge badge-info">En Proceso</span>
                      @break
                    @case('completada')
                      <span class="badge badge-success">Completada</span>
                      @break
                    @case('cancelada')
                      <span class="badge badge-danger">Cancelada</span>
                      @break
                    @default
                      <span class="badge badge-secondary">{{ $orden->estado }}</span>
                  @endswitch
                </td>
                <td>{{ $orden->fecha_inicio ? $orden->fecha_inicio->format('d/m/Y') : '-' }}</td>
                <td>
                  <a href="{{ route('admin.ordenes_trabajo.show', $orden->id) }}" class="btn btn-info btn-sm">
                    <i class="mdi mdi-eye"></i>
                  </a>
                  <a href="{{ route('admin.ordenes_trabajo.edit', $orden->id) }}" class="btn btn-warning btn-sm">
                    <i class="mdi mdi-pencil"></i>
                  </a>
                  <form action="{{ route('admin.ordenes_trabajo.destroy', $orden->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de eliminar esta orden?')">
                      <i class="mdi mdi-delete"></i>
                    </button>
                  </form>
                </td>
              </tr>
              @empty
              <tr>
                <td colspan="6" class="text-center">No hay órdenes de trabajo</td>
              </tr>
              @endforelse
            </tbody>
          </table>
        </div>
        
        <div class="mt-4">
          <div class="mt-4 custom-pagination">{{ $ordenes->links('pagination.bootstrap-custom') }}</div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection