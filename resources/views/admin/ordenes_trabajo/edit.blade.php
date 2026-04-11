@extends('admin.layout')

@section('title', 'Editar Orden de Trabajo - Ramtclimatec')

@section('content')
<div class="row">
  <div class="col-md-12 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <h4 class="card-title">Editar Orden de Trabajo</h4>
        
        <form method="POST" action="{{ route('admin.ordenes_trabajo.update', $ordenes_trabajo->id) }}">
          @csrf
          @method('PUT')
          
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="cliente_id">Cliente *</label>
                <select class="form-control" id="cliente_id" name="cliente_id" required>
                  @foreach($clientes as $cliente)
                    <option value="{{ $cliente->id }}" {{ $ordenes_trabajo->cliente_id == $cliente->id ? 'selected' : '' }}>
                      {{ $cliente->nombre }}
                    </option>
                  @endforeach
                </select>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="direccion_id">Dirección *</label>
                <select class="form-control" id="direccion_id" name="direccion_id" required>
                  @foreach($direcciones as $direccion)
                    <option value="{{ $direccion->id }}" {{ $ordenes_trabajo->direccion_id == $direccion->id ? 'selected' : '' }}>
                      {{ $direccion->direccion }}
                    </option>
                  @endforeach
                </select>
              </div>
            </div>
          </div>
          
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="tipo_servicio">Tipo de Servicio *</label>
                <select class="form-control" id="tipo_servicio" name="tipo_servicio" required>
                  <option value="mantenimiento" {{ $ordenes_trabajo->tipo_servicio == 'mantenimiento' ? 'selected' : '' }}>Mantenimiento</option>
                  <option value="instalacion" {{ $ordenes_trabajo->tipo_servicio == 'instalacion' ? 'selected' : '' }}>Instalación</option>
                  <option value="reparacion" {{ $ordenes_trabajo->tipo_servicio == 'reparacion' ? 'selected' : '' }}>Reparación</option>
                  <option value="inspeccion" {{ $ordenes_trabajo->tipo_servicio == 'inspeccion' ? 'selected' : '' }}>Inspección</option>
                </select>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="estado">Estado *</label>
                <select class="form-control" id="estado" name="estado" required>
                  <option value="pendiente" {{ $ordenes_trabajo->estado == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                  <option value="en_proceso" {{ $ordenes_trabajo->estado == 'en_proceso' ? 'selected' : '' }}>En Proceso</option>
                  <option value="completada" {{ $ordenes_trabajo->estado == 'completada' ? 'selected' : '' }}>Completada</option>
                  <option value="cancelada" {{ $ordenes_trabajo->estado == 'cancelada' ? 'selected' : '' }}>Cancelada</option>
                </select>
              </div>
            </div>
          </div>
          
          <div class="form-group">
            <label for="descripcion">Descripción</label>
            <textarea class="form-control" id="descripcion" name="descripcion" rows="3">{{ $ordenes_trabajo->descripcion }}</textarea>
          </div>
          
          <button type="submit" class="btn btn-primary mr-2">Actualizar</button>
          <a href="{{ route('admin.ordenes_trabajo.index') }}" class="btn btn-light">Cancelar</a>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection