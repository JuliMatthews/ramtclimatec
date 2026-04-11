@extends('admin.layout')

@section('title', 'Ver Dirección - Ramtclimatec')

@section('content')
<div class="row">
  <div class="col-md-12 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <h4 class="card-title">Detalles de la Dirección</h4>
        
        <div class="row">
          <div class="col-md-6">
            <p><strong>Cliente:</strong> {{ $direccione->cliente->nombre ?? 'Sin cliente' }}</p>
            <p><strong>Dirección:</strong> 
              {{ $direccione->calle }}
              @if($direccione->numero){{ ' ' . $direccione->numero }}@endif
              @if($direccione->depto), {{ $direccione->depto }}@endif
            </p>
            <p><strong>Teléfono:</strong> {{ $direccione->telefono ?? 'No registrado' }}</p>
          </div>
          <div class="col-md-6">
            <p><strong>Región:</strong> {{ $direccione->region ?? 'No registrada' }}</p>
            <p><strong>Provincia:</strong> {{ $direccione->provincia ?? 'No registrada' }}</p>
            <p><strong>Comuna:</strong> {{ $direccione->comuna ?? 'No registrada' }}</p>
            <p><strong>Ciudad:</strong> {{ $direccione->ciudad ?? 'No registrada' }}</p>
          </div>
        </div>
        
        @if($direccione->referencia)
        <div class="mt-3">
          <p><strong>Referencia:</strong> {{ $direccione->referencia }}</p>
        </div>
        @endif
        
        <div class="mt-4">
          <a href="{{ route('admin.direcciones.edit', $direccione->id) }}" class="btn btn-warning">
            <i class="mdi mdi-pencil"></i> Editar
          </a>
          <a href="{{ route('admin.direcciones.index') }}" class="btn btn-light">Volver</a>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection