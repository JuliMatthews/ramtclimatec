@extends('admin.layout')

@section('title', 'Nueva Orden de Trabajo - Ramtclimatec')

@section('content')
<div class="row">
  <div class="col-md-12 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <h4 class="card-title">Nueva Orden de Trabajo</h4>
        
        <form method="POST" action="{{ route('admin.ordenes_trabajo.store') }}">
          @csrf
          
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="cliente_id">Cliente *</label>
                <select class="form-control" id="cliente_id" name="cliente_id" required>
                  <option value="">Seleccionar cliente</option>
                  @foreach($clientes as $cliente)
                    <option value="{{ $cliente->id }}">{{ $cliente->nombre }} ({{ $cliente->rut }})</option>
                  @endforeach
                </select>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="direccion_id">Dirección *</label>
                <select class="form-control" id="direccion_id" name="direccion_id" required>
                  <option value="">Seleccionar dirección</option>
                  @foreach($direcciones as $direccion)
                    <option value="{{ $direccion->id }}">{{ $direccion->direccion }} - {{ $direccion->comuna }}</option>
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
                  <option value="mantenimiento">Mantenimiento</option>
                  <option value="instalacion">Instalación</option>
                  <option value="reparacion">Reparación</option>
                  <option value="inspeccion">Inspección</option>
                </select>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="estado">Estado *</label>
                <select class="form-control" id="estado" name="estado" required>
                  <option value="pendiente">Pendiente</option>
                  <option value="en_proceso">En Proceso</option>
                  <option value="completada">Completada</option>
                  <option value="cancelada">Cancelada</option>
                </select>
              </div>
            </div>
          </div>
          
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="fecha_inicio">Fecha Inicio</label>
                <input type="date" class="form-control" id="fecha_inicio" name="fecha_inicio" value="{{ old('fecha_inicio') }}">
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="fecha_termino">Fecha Término</label>
                <input type="date" class="form-control" id="fecha_termino" name="fecha_termino" value="{{ old('fecha_termino') }}">
              </div>
            </div>
          </div>
          
          <div class="form-group">
            <label for="cantidad_equipos">Cantidad de Equipos</label>
            <input type="number" class="form-control" id="cantidad_equipos" name="cantidad_equipos" value="{{ old('cantidad_equipos', 1) }}" min="1">
          </div>
          
          <div class="form-group">
            <label for="descripcion">Descripción</label>
            <textarea class="form-control" id="descripcion" name="descripcion" rows="3">{{ old('descripcion') }}</textarea>
          </div>
          
          <div class="form-group">
            <label for="observaciones">Observaciones</label>
            <textarea class="form-control" id="observaciones" name="observaciones" rows="2">{{ old('observaciones') }}</textarea>
          </div>
          
          <div class="form-group">
            <label>Técnicos Asignados</label>
            <select class="form-control" name="tecnicos[]" multiple>
              @foreach($tecnicos as $tecnico)
                <option value="{{ $tecnico->id }}">{{ $tecnico->nombre }}</option>
              @endforeach
            </select>
            <small class="text-muted">Mantén presionado Ctrl para seleccionar múltiples</small>
          </div>
          
          <div class="form-group">
            <label>Ayudantes Asignados</label>
            <select class="form-control" name="ayudantes[]" multiple>
              @foreach($ayudantes as $ayudante)
                <option value="{{ $ayudante->id }}">{{ $ayudante->nombre }}</option>
              @endforeach
            </select>
          </div>
          
          <button type="submit" class="btn btn-primary mr-2">Guardar</button>
          <a href="{{ route('admin.ordenes_trabajo.index') }}" class="btn btn-light">Cancelar</a>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection