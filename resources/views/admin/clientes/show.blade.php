@extends('admin.layout')

@section('title', 'Ver Cliente - Ramtclimatec')

@section('content')
<div class="row">
  <div class="col-md-12 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <h4 class="card-title">Detalles del Cliente</h4>
        
        <div class="row">
          <div class="col-md-6">
            <p><strong>RUT:</strong> {{ $cliente->rut }}</p>
            <p><strong>Nombre:</strong> {{ $cliente->nombre }}</p>
            <p><strong>Tipo:</strong> {{ ucfirst($cliente->tipo) }}</p>
            <p><strong>Email:</strong> {{ $cliente->email ?? 'No registrado' }}</p>
            <p><strong>Teléfono:</strong> {{ $cliente->telefono ?? 'No registrado' }}</p>
          </div>
          <div class="col-md-6">
            <p><strong>Región:</strong> {{ $cliente->region ?? 'No registrada' }}</p>
            <p><strong>Provincia:</strong> {{ $cliente->provincia ?? 'No registrada' }}</p>
            <p><strong>Comuna:</strong> {{ $cliente->comuna ?? 'No registrada' }}</p>
            <p><strong>Estado:</strong> 
              @if($cliente->activo)
                <span class="badge badge-success">Activo</span>
              @else
                <span class="badge badge-secondary">Inactivo</span>
              @endif
            </p>
            <p><strong>Próxima Mantención:</strong> {{ $cliente->proxima_mantencion ?? 'No programada' }}</p>
          </div>
        </div>
        
        @if($cliente->observaciones)
        <div class="mt-4">
          <h5>Observaciones</h5>
          <p>{{ $cliente->observaciones }}</p>
        </div>
        @endif
        
        <div class="mt-4">
          <a href="{{ route('admin.clientes.edit', $cliente->id) }}" class="btn btn-warning">
            <i class="mdi mdi-pencil"></i> Editar
          </a>
          <a href="{{ route('admin.clientes.index') }}" class="btn btn-light">Volver</a>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection