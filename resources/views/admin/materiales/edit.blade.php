@extends('admin.layout')

@section('title', 'Editar Material - Ramtclimatec')

@section('content')
<div class="row">
  <div class="col-md-12 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <h4 class="card-title">Editar Material</h4>
        <form method="POST" action="{{ route('admin.materiales.update', $material->id) }}">
          @csrf @method('PUT')
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="nombre">Nombre *</label>
                <input type="text" class="form-control" id="nombre" name="nombre" required value="{{ old('nombre', $material->nombre) }}">
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="tipo">Tipo</label>
                <input type="text" class="form-control" id="tipo" name="tipo" value="{{ old('tipo', $material->tipo) }}">
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="unidad">Unidad</label>
                <input type="text" class="form-control" id="unidad" name="unidad" value="{{ old('unidad', $material->unidad) }}">
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="stock">Stock</label>
                <input type="number" class="form-control" id="stock" name="stock" value="{{ old('stock', $material->stock) }}">
              </div>
            </div>
          </div>
          <button type="submit" class="btn btn-primary mr-2">Actualizar</button>
          <a href="{{ route('admin.materiales.index') }}" class="btn btn-light">Cancelar</a>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection