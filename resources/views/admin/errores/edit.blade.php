@extends('admin.layout')

@section('title', 'Editar Error - Ramtclimatec')

@section('content')
<div class="row">
  <div class="col-md-12 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <h4 class="card-title">Editar Error</h4>
        <form method="POST" action="{{ route('admin.errores.update', $error->id) }}">
          @csrf @method('PUT')
          <div class="form-group">
            <label for="nombre">Nombre *</label>
            <input type="text" class="form-control" id="nombre" name="nombre" required value="{{ old('nombre', $error->nombre) }}">
          </div>
          <div class="form-group">
            <label for="tipo">Tipo</label>
            <select class="form-control" id="tipo" name="tipo">
              <option value="equipo" {{ $error->tipo == 'equipo' ? 'selected' : '' }}>Equipo</option>
              <option value="sistema" {{ $error->tipo == 'sistema' ? 'selected' : '' }}>Sistema</option>
              <option value="proceso" {{ $error->tipo == 'proceso' ? 'selected' : '' }}>Proceso</option>
            </select>
          </div>
          <div class="form-group">
            <label for="descripcion">Descripción</label>
            <textarea class="form-control" id="descripcion" name="descripcion" rows="3">{{ old('descripcion', $error->descripcion) }}</textarea>
          </div>
          <button type="submit" class="btn btn-primary mr-2">Actualizar</button>
          <a href="{{ route('admin.errores.index') }}" class="btn btn-light">Cancelar</a>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection