@extends('admin.layout')

@section('title', 'Ver Orden de Trabajo - Ramtclimatec')

@section('content')
<div class="row">
  <div class="col-md-12 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <h4 class="card-title">Detalles de la Orden de Trabajo</h4>
        
        <div class="row">
          <div class="col-md-6">
            <p><strong>ID:</strong> #{{ $ordenes_trabajo->id }}</p>
            <p><strong>Cliente:</strong> {{ $ordenes_trabajo->cliente->nombre ?? 'Sin cliente' }}</p>
            <p><strong>Dirección:</strong> {{ $ordenes_trabajo->direccion->direccion ?? 'Sin dirección' }}</p>
            <p><strong>Tipo de Servicio:</strong> {{ ucfirst($ordenes_trabajo->tipo_servicio) }}</p>
          </div>
          <div class="col-md-6">
            <p><strong>Estado:</strong> 
              @switch($ordenes_trabajo->estado)
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
              @endswitch
            </p>
            <p><strong>Fecha Inicio:</strong> {{ $ordenes_trabajo->fecha_inicio ? $ordenes_trabajo->fecha_inicio->format('d/m/Y') : 'No definida' }}</p>
            <p><strong>Fecha Término:</strong> {{ $ordenes_trabajo->fecha_termino ? $ordenes_trabajo->fecha_termino->format('d/m/Y') : 'No definida' }}</p>
            <p><strong>Cantidad Equipos:</strong> {{ $ordenes_trabajo->cantidad_equipos ?? 0 }}</p>
          </div>
        </div>
        
        @if($ordenes_trabajo->descripcion)
        <div class="mt-4">
          <h5>Descripción</h5>
          <p>{{ $ordenes_trabajo->descripcion }}</p>
        </div>
        @endif
        
        @if($ordenes_trabajo->observaciones)
        <div class="mt-4">
          <h5>Observaciones</h5>
          <p>{{ $ordenes_trabajo->observaciones }}</p>
        </div>
        @endif
        
        <div class="mt-4">
          <a href="{{ route('admin.ordenes_trabajo.edit', $ordenes_trabajo->id) }}" class="btn btn-warning">
            <i class="mdi mdi-pencil"></i> Editar
          </a>
          <a href="{{ route('admin.ordenes_trabajo.index') }}" class="btn btn-light">Volver</a>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection