@extends('admin.layout')

@section('title', 'Nuevo Equipo - Ramtclimatec')

@section('content')
<div class="row">
  <div class="col-md-12 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <h4 class="card-title">Nuevo Equipo</h4>
        
        <form method="POST" action="{{ route('admin.equipos.store') }}">
          @csrf
          
          <h6 class="text-primary mt-4 mb-3">Vinculación</h6>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="cliente_id">Cliente *</label>
                <select class="form-control" id="cliente_id" name="cliente_id" required onchange="cargarDirecciones()">
                  <option value="">Seleccionar cliente</option>
                  @foreach($clientes as $cliente)
                    <option value="{{ $cliente->id }}">{{ $cliente->nombre }}</option>
                  @endforeach
                </select>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="direccion_id">Dirección</label>
                <select class="form-control" id="direccion_id" name="direccion_id">
                  <option value="">Seleccionar dirección</option>
                </select>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="ubicacion">Ubicación</label>
                <input type="text" class="form-control" id="ubicacion" name="ubicacion" value="{{ old('ubicacion') }}" placeholder="Ej: Sala de máquinas">
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="estado">Estado</label>
                <select class="form-control" id="estado" name="estado">
                  <option value="1" {{ old('estado', 1) == 1 ? 'selected' : '' }}>Activo</option>
                  <option value="0" {{ old('estado') == 0 ? 'selected' : '' }}>Inactivo</option>
                </select>
              </div>
            </div>
          </div>
          
          <h6 class="text-primary mt-4 mb-3">Identificación del Equipo</h6>
          <div class="row">
            <div class="col-md-4">
              <div class="form-group">
                <label for="marca">Fabricante (Marca) *</label>
                <select class="form-control" id="marca" name="marca" required>
                  <option value="">Seleccionar</option>
                  @php
                  $marcas = ['Airwell','Amana','Anwo','Ariston','Aux','AUX Air','Baxi','BGH','Bryant','Carrier','Chigo','Clark','Coleman','Cold Point','Comfortmaker','Daewoo','Daikin','Daitsu','Ecox','Electrolux','Fagor','Frigidaire','Fujitsu','Galanz','General Electric (GE Appliances)','Goodman','Gree','Haier','Heil','Hisense','Hisense Kelon','Hitecsa','Hitachi','Hyundai','Indurama','Junkers','Kelon','Kosner','Khone','Lennox','LG','Mabe','Midea','Mirage','Miray','Mitsubishi Electric','Mitsubishi Heavy Industries','Nordyne','Olimpo','Panasonic','Philco','Prime','Rheem','Ruud','Samsung','Sankey','Sanyo','Saunier Duval','Sharp','Surrey','TCL','Tempstar','Toshiba','Trane','Vaillant','Westinghouse','Whirlpool','York'];
                  @endphp
                  @foreach($marcas as $marca)
                    <option value="{{ $marca }}" {{ old('marca') == $marca ? 'selected' : '' }}>{{ $marca }}</option>
                  @endforeach
                </select>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label for="modelo">Modelo</label>
                <input type="text" class="form-control" id="modelo" name="modelo" value="{{ old('modelo') }}">
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label for="numero_serie">Número de Serie</label>
                <input type="text" class="form-control" id="numero_serie" name="numero_serie" value="{{ old('numero_serie') }}">
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-4">
              <div class="form-group">
                <label for="tipo_equipo">Tipo de Equipo</label>
                <select class="form-control" id="tipo_equipo" name="tipo_equipo">
                  <option value="">Seleccionar</option>
                  @php
                  $tipos = ['Split muro','Cassette','Ducto','Piso techo','Portátil','Ventana','VRF','Chiller','Rooftop'];
                  @endphp
                  @foreach($tipos as $tipo)
                    <option value="{{ $tipo }}" {{ old('tipo_equipo') == $tipo ? 'selected' : '' }}>{{ $tipo }}</option>
                  @endforeach
                </select>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label for="pais_fabricacion">País de Fabricación</label>
                <input type="text" class="form-control" id="pais_fabricacion" name="pais_fabricacion" value="{{ old('pais_fabricacion') }}">
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label for="fecha_fabricacion">Fecha de Fabricación</label>
                <input type="date" class="form-control" id="fecha_fabricacion" name="fecha_fabricacion" value="{{ old('fecha_fabricacion') }}">
              </div>
            </div>
          </div>
          
          <h6 class="text-primary mt-4 mb-3">Datos Eléctricos</h6>
          <div class="row">
            <div class="col-md-3">
              <div class="form-group">
                <label for="tension_nominal">Tensión Nominal (V)</label>
                <input type="text" class="form-control" id="tension_nominal" name="tension_nominal" value="{{ old('tension_nominal') }}">
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label for="frecuencia">Frecuencia (Hz)</label>
                <input type="text" class="form-control" id="frecuencia" name="frecuencia" value="{{ old('frecuencia') }}">
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label for="potencia_calefaccion">Potencia Calefacción (W)</label>
                <input type="text" class="form-control" id="potencia_calefaccion" name="potencia_calefaccion" value="{{ old('potencia_calefaccion') }}">
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label for="potencia_enfriamiento">Potencia Enfriamiento (W)</label>
                <input type="text" class="form-control" id="potencia_enfriamiento" name="potencia_enfriamiento" value="{{ old('potencia_enfriamiento') }}">
              </div>
            </div>
          </div>
          
          <h6 class="text-primary mt-4 mb-3">Capacidades y Refrigerante</h6>
          <div class="row">
            <div class="col-md-3">
              <div class="form-group">
                <label for="capacidad_calefaccion_btu">Cap. Calefacción (BTU)</label>
                <input type="text" class="form-control" id="capacidad_calefaccion_btu" name="capacidad_calefaccion_btu" value="{{ old('capacidad_calefaccion_btu') }}">
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label for="capacidad_enfriamiento_btu">Cap. Enfriamiento (BTU)</label>
                <input type="text" class="form-control" id="capacidad_enfriamiento_btu" name="capacidad_enfriamiento_btu" value="{{ old('capacidad_enfriamiento_btu') }}">
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label for="masa_refrigerante">Masa Refrigerante (kg)</label>
                <input type="text" class="form-control" id="masa_refrigerante" name="masa_refrigerante" value="{{ old('masa_refrigerante') }}">
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label for="tipo_refrigerante">Tipo Refrigerante</label>
                <input type="text" class="form-control" id="tipo_refrigerante" name="tipo_refrigerante" value="{{ old('tipo_refrigerante') }}" placeholder="Ej: R410A">
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-3">
              <div class="form-group">
                <label for="presion_minima">Presión Mínima (bar)</label>
                <input type="text" class="form-control" id="presion_minima" name="presion_minima" value="{{ old('presion_minima') }}">
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label for="presion_maxima">Presión Máxima (bar)</label>
                <input type="text" class="form-control" id="presion_maxima" name="presion_maxima" value="{{ old('presion_maxima') }}">
              </div>
            </div>
          </div>
          
          <h6 class="text-primary mt-4 mb-3">Mantención</h6>
          <div class="row">
            <div class="col-md-4">
              <div class="form-group">
                <label for="ultima_mantencion">Última Mantención</label>
                <input type="date" class="form-control" id="ultima_mantencion" name="ultima_mantencion" value="{{ old('ultima_mantencion') }}">
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label for="proxima_mantencion">Próxima Mantención (calculada automáticamente)</label>
                <input type="date" class="form-control" id="proxima_mantencion" name="proxima_mantencion" value="{{ old('proxima_mantencion') }}" readonly style="background-color: #f5f5f5;">
              </div>
            </div>
          </div>
          
          <div class="form-group mt-4">
            <label for="observaciones">Observaciones</label>
            <textarea class="form-control" id="observaciones" name="observaciones" rows="3">{{ old('observaciones') }}</textarea>
          </div>
          
          <button type="submit" class="btn btn-primary mr-2">Guardar</button>
          <a href="{{ route('admin.equipos.index') }}" class="btn btn-light">Cancelar</a>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
function cargarDirecciones() {
  const clienteId = document.getElementById('cliente_id').value;
  const direccionSelect = document.getElementById('direccion_id');
  
  direccionSelect.innerHTML = '<option value="">Cargando...</option>';
  
  if (!clienteId) {
    direccionSelect.innerHTML = '<option value="">Seleccionar dirección</option>';
    return;
  }
  
  fetch('/admin/direcciones/cliente/' + clienteId)
    .then(response => response.json())
    .then(data => {
      direccionSelect.innerHTML = '<option value="">Seleccionar dirección</option>';
      data.forEach(dir => {
        const option = document.createElement('option');
        option.value = dir.id;
        option.textContent = dir.direccion_completa;
        direccionSelect.appendChild(option);
      });
    })
    .catch(error => {
      console.error('Error:', error);
      direccionSelect.innerHTML = '<option value="">Error al cargar</option>';
    });
}

document.getElementById('ultima_mantencion').addEventListener('change', function() {
  if (this.value) {
    const fecha = new Date(this.value);
    fecha.setMonth(fecha.getMonth() + 6);
    const year = fecha.getFullYear();
    const month = String(fecha.getMonth() + 1).padStart(2, '0');
    const day = String(fecha.getDate()).padStart(2, '0');
    document.getElementById('proxima_mantencion').value = year + '-' + month + '-' + day;
  }
});
</script>
@endsection