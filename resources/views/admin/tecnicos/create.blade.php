@extends('admin.layout')

@section('title', 'Nuevo Técnico - Ramtclimatec')

@section('content')
<div class="row">
  <div class="col-md-12 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <h4 class="card-title">Nuevo Técnico</h4>
        <form method="POST" action="{{ route('admin.tecnicos.store') }}">
          @csrf
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="rut">RUT *</label>
                <input type="text" class="form-control" id="rut" name="rut" required>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="nombre">Nombre *</label>
                <input type="text" class="form-control" id="nombre" name="nombre" required>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="telefono">Teléfono</label>
                <input type="text" class="form-control" id="telefono" name="telefono">
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" name="email">
              </div>
            </div>
          </div>
          <div class="form-group">
            <label for="especialidad">Especialidad</label>
            <input type="text" class="form-control" id="especialidad" name="especialidad">
          </div>
          <button type="submit" class="btn btn-primary mr-2">Guardar</button>
          <a href="{{ route('admin.tecnicos.index') }}" class="btn btn-light">Cancelar</a>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection