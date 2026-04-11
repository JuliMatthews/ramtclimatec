@extends('admin.layout')

@section('title', 'Editar Ayudante - Ramtclimatec')

@section('content')
<div class="row">
  <div class="col-md-12 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <h4 class="card-title">Editar Ayudante</h4>
        <form method="POST" action="{{ route('admin.ayudantes.update', $ayudante->id) }}">
          @csrf @method('PUT')
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="rut">RUT</label>
                <input type="text" class="form-control" id="rut" name="rut" value="{{ old('rut', $ayudante->rut) }}">
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="nombre">Nombre *</label>
                <input type="text" class="form-control" id="nombre" name="nombre" required value="{{ old('nombre', $ayudante->nombre) }}">
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="telefono">Teléfono</label>
                <input type="text" class="form-control" id="telefono" name="telefono" value="{{ old('telefono', $ayudante->telefono) }}">
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $ayudante->email) }}">
              </div>
            </div>
          </div>
          <button type="submit" class="btn btn-primary mr-2">Actualizar</button>
          <a href="{{ route('admin.ayudantes.index') }}" class="btn btn-light">Cancelar</a>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection