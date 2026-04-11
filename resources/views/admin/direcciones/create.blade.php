@extends('admin.layout')

@section('title', 'Nueva Dirección - Ramtclimatec')

@section('content')
<div class="row">
  <div class="col-md-12 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <h4 class="card-title">Nueva Dirección</h4>
        
        <form method="POST" action="{{ route('admin.direcciones.store') }}">
          @csrf
          
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="cliente_id">Cliente *</label>
                <select class="form-control" id="cliente_id" name="cliente_id" required>
                  <option value="">Seleccionar cliente</option>
                  @foreach($clientes as $cliente)
                    <option value="{{ $cliente->id }}">{{ $cliente->nombre }}</option>
                  @endforeach
                </select>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="telefono">Teléfono</label>
                <input type="text" class="form-control" id="telefono" name="telefono" value="{{ old('telefono') }}">
              </div>
            </div>
          </div>
          
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="calle">Calle *</label>
                <input type="text" class="form-control" id="calle" name="calle" required value="{{ old('calle') }}" placeholder="Ej: Av. Principal">
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label for="numero">Número</label>
                <input type="text" class="form-control" id="numero" name="numero" value="{{ old('numero') }}" placeholder="123">
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label for="depto">Depto/Oficina</label>
                <input type="text" class="form-control" id="depto" name="depto" value="{{ old('depto') }}" placeholder="Apto 501">
              </div>
            </div>
          </div>
          
          <div class="row">
            <div class="col-md-4">
              <div class="form-group">
                <label for="region">Región</label>
                <select class="form-control" id="region" name="region">
                  <option value="">Seleccionar región</option>
                  @foreach(array_keys(config('comunas')) as $region)
                    <option value="{{ $region }}" {{ old('region') == $region ? 'selected' : '' }}>{{ $region }}</option>
                  @endforeach
                </select>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label for="provincia">Provincia</label>
                <select class="form-control" id="provincia" name="provincia" disabled>
                  <option value="">Seleccionar provincia</option>
                </select>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label for="comuna">Comuna</label>
                <select class="form-control" id="comuna" name="comuna" disabled>
                  <option value="">Seleccionar comuna</option>
                </select>
              </div>
            </div>
          </div>
          
          <div class="form-group">
            <label for="ciudad">Ciudad</label>
            <input type="text" class="form-control" id="ciudad" name="ciudad" value="{{ old('ciudad') }}">
          </div>
          
          <div class="form-group">
            <label for="referencia">Referencia</label>
            <textarea class="form-control" id="referencia" name="referencia" rows="2">{{ old('referencia') }}</textarea>
          </div>
          
          <button type="submit" class="btn btn-primary mr-2">Guardar</button>
          <a href="{{ route('admin.direcciones.index') }}" class="btn btn-light">Cancelar</a>
        </form>
      </div>
    </div>
  </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
  const comunas = @json(config('comunas'));
  const regionSelect = document.getElementById('region');
  const provinciaSelect = document.getElementById('provincia');
  const comunaSelect = document.getElementById('comuna');
  
  regionSelect.addEventListener('change', function() {
    const region = this.value;
    provinciaSelect.innerHTML = '<option value="">Seleccionar provincia</option>';
    comunaSelect.innerHTML = '<option value="">Seleccionar comuna</option>';
    if (region && comunas[region]) {
      provinciaSelect.disabled = false;
      Object.keys(comunas[region]).forEach(function(provincia) {
        const option = document.createElement('option');
        option.value = provincia;
        option.textContent = provincia;
        provinciaSelect.appendChild(option);
      });
    } else {
      provinciaSelect.disabled = true;
      comunaSelect.disabled = true;
    }
  });
  
  provinciaSelect.addEventListener('change', function() {
    const region = regionSelect.value;
    const provincia = this.value;
    comunaSelect.innerHTML = '<option value="">Seleccionar comuna</option>';
    if (region && provincia && comunas[region] && comunas[region][provincia]) {
      comunaSelect.disabled = false;
      comunas[region][provincia].forEach(function(comuna) {
        const option = document.createElement('option');
        option.value = comuna;
        option.textContent = comuna;
        comunaSelect.appendChild(option);
      });
    } else {
      comunaSelect.disabled = true;
    }
  });
});
</script>
@endpush
@endsection