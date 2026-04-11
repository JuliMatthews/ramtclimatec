@extends('admin.layout')

@section('title', 'Editar Cliente - Ramtclimatec')

@section('content')
<div class="row">
  <div class="col-md-12 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <h4 class="card-title">Editar Cliente</h4>
        
        <form method="POST" action="{{ route('admin.clientes.update', $cliente->id) }}">
          @csrf
          @method('PUT')
          
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="rut">RUT *</label>
                <input type="text" class="form-control" id="rut" name="rut" required value="{{ old('rut', $cliente->rut) }}">
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="nombre">Nombre *</label>
                <input type="text" class="form-control" id="nombre" name="nombre" required value="{{ old('nombre', $cliente->nombre) }}">
              </div>
            </div>
          </div>
          
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $cliente->email) }}">
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="telefono">Teléfono</label>
                <input type="text" class="form-control" id="telefono" name="telefono" value="{{ old('telefono', $cliente->telefono) }}">
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
                    <option value="{{ $region }}" {{ (old('region', $cliente->region) == $region) ? 'selected' : '' }}>{{ $region }}</option>
                  @endforeach
                </select>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label for="provincia">Provincia</label>
                <select class="form-control" id="provincia" name="provincia" {{ $cliente->provincia ? '' : 'disabled' }}>
                  <option value="">Seleccionar provincia</option>
                  @if($cliente->region && config('comunas.' . $cliente->region))
                    @foreach(array_keys(config('comunas.' . $cliente->region)) as $provincia)
                      <option value="{{ $provincia }}" {{ (old('provincia', $cliente->provincia) == $provincia) ? 'selected' : '' }}>{{ $provincia }}</option>
                    @endforeach
                  @endif
                </select>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label for="comuna">Comuna</label>
                <select class="form-control" id="comuna" name="comuna" {{ $cliente->comuna ? '' : 'disabled' }}>
                  <option value="">Seleccionar comuna</option>
                  @if($cliente->region && $cliente->provincia && config('comunas.' . $cliente->region . '.' . $cliente->provincia))
                    @foreach(config('comunas.' . $cliente->region . '.' . $cliente->provincia) as $comuna)
                      <option value="{{ $comuna }}" {{ (old('comuna', $cliente->comuna) == $comuna) ? 'selected' : '' }}>{{ $comuna }}</option>
                    @endforeach
                  @endif
                </select>
              </div>
            </div>
          </div>
          
          <div class="form-group">
            <label for="tipo">Tipo</label>
            <select class="form-control" id="tipo" name="tipo">
              <option value="empresa" {{ $cliente->tipo == 'empresa' ? 'selected' : '' }}>Empresa</option>
              <option value="particular" {{ $cliente->tipo == 'particular' ? 'selected' : '' }}>Particular</option>
            </select>
          </div>
          
          <div class="form-group">
            <label for="observaciones">Observaciones</label>
            <textarea class="form-control" id="observaciones" name="observaciones" rows="3">{{ old('observaciones', $cliente->observaciones) }}</textarea>
          </div>
          
          <div class="form-group">
            <label for="proxima_mantencion">Próxima Mantención</label>
            <input type="date" class="form-control" id="proxima_mantencion" name="proxima_mantencion" value="{{ old('proxima_mantencion', $cliente->proxima_mantencion) }}">
          </div>
          
          <div class="form-group">
            <div class="form-check">
              <input type="checkbox" class="form-check-input" id="activo" name="activo" value="1" {{ $cliente->activo ? 'checked' : '' }}>
              <label class="form-check-label" for="activo">
                Cliente activo
              </label>
            </div>
          </div>
          
          <button type="submit" class="btn btn-primary mr-2">Actualizar</button>
          <a href="{{ route('admin.clientes.index') }}" class="btn btn-light">Cancelar</a>
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