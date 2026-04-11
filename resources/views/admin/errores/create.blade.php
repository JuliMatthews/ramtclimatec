@extends('admin.layout')

@section('title', 'Nuevo Error - Ramtclimatec')

@section('content')
<div class="row">
  <div class="col-md-12 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <h4 class="card-title">Nuevo Error</h4>
        <form method="POST" action="{{ route('admin.errores.store') }}">
          @csrf
          <div class="form-group">
            <label for="nombre">Nombre *</label>
            <input type="text" class="form-control" id="nombre" name="nombre" required>
          </div>
          <div class="form-group">
            <label for="tipo">Tipo</label>
            <select class="form-control" id="tipo" name="tipo">
              <option value="equipo">Equipo</option>
              <option value="sistema">Sistema</option>
              <option value="proceso">Proceso</option>
            </select>
          </div>
          <div class="form-group">
            <label for="descripcion">Descripción</label>
            <textarea class="form-control" id="descripcion" name="descripcion" rows="3"></textarea>
          </div>
          <button type="submit" class="btn btn-primary mr-2">Guardar</button>
          <a href="{{ route('admin.errores.index') }}" class="btn btn-light">Cancelar</a>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection