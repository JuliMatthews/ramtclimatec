@extends('admin.layout')

@section('title', 'Ver Equipo - Ramtclimatec')

@section('content')
<div class="row">
  <div class="col-md-12 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-4">
          <h4 class="card-title">Detalles del Equipo</h4>
          <div>
            <a href="{{ route('admin.equipos.edit', $equipo->id) }}" class="btn btn-warning">
              <i class="mdi mdi-pencil"></i> Editar
            </a>
            <a href="{{ route('admin.equipos.porCliente', $equipo->cliente_id) }}" class="btn btn-secondary ml-2">
              <i class="mdi mdi-arrow-left"></i> Volver
            </a>
          </div>
        </div>

        <h6 class="text-primary mt-4 mb-3">Vinculación</h6>
        <div class="row">
          <div class="col-md-4">
            <p><strong>Cliente:</strong> {{ $equipo->cliente->nombre ?? 'Sin cliente' }}</p>
          </div>
          <div class="col-md-4">
            <p><strong>Dirección:</strong> {{ $equipo->direccion->direccion_completa ?? 'Sin dirección' }}</p>
          </div>
          <div class="col-md-4">
            <p><strong>Ubicación:</strong> {{ $equipo->ubicacion ?? 'No especificada' }}</p>
          </div>
        </div>
        <div class="row">
          <div class="col-md-4">
            <p><strong>Estado:</strong> 
              @if($equipo->activo)
                <span class="badge badge-success">Activo</span>
              @else
                <span class="badge badge-secondary">Inactivo</span>
              @endif
            </p>
          </div>
        </div>

        <h6 class="text-primary mt-4 mb-3">Identificación del Equipo</h6>
        <div class="row">
          <div class="col-md-3">
            <p><strong>Marca:</strong> {{ $equipo->marca ?? '-' }}</p>
          </div>
          <div class="col-md-3">
            <p><strong>Modelo:</strong> {{ $equipo->modelo ?? '-' }}</p>
          </div>
          <div class="col-md-3">
            <p><strong>N° Serie:</strong> {{ $equipo->numero_serie ?? '-' }}</p>
          </div>
          <div class="col-md-3">
            <p><strong>Tipo:</strong> {{ $equipo->tipo_equipo ?? '-' }}</p>
          </div>
        </div>
        <div class="row">
          <div class="col-md-4">
            <p><strong>País de Fabricación:</strong> {{ $equipo->pais_fabricacion ?? '-' }}</p>
          </div>
          <div class="col-md-4">
            <p><strong>Fecha de Fabricación:</strong> {{ $equipo->fecha_fabricacion ?? '-' }}</p>
          </div>
        </div>

        <h6 class="text-primary mt-4 mb-3">Datos Eléctricos</h6>
        <div class="row">
          <div class="col-md-3">
            <p><strong>Tensión Nominal:</strong> {{ $equipo->tension_nominal ?? '-' }} V</p>
          </div>
          <div class="col-md-3">
            <p><strong>Frecuencia:</strong> {{ $equipo->frecuencia ?? '-' }} Hz</p>
          </div>
          <div class="col-md-3">
            <p><strong>Potencia Calefacción:</strong> {{ $equipo->potencia_calefaccion ?? '-' }} W</p>
          </div>
          <div class="col-md-3">
            <p><strong>Potencia Enfriamiento:</strong> {{ $equipo->potencia_enfriamiento ?? '-' }} W</p>
          </div>
        </div>

        <h6 class="text-primary mt-4 mb-3">Capacidades y Refrigerante</h6>
        <div class="row">
          <div class="col-md-3">
            <p><strong>Cap. Calefacción:</strong> {{ $equipo->capacidad_calefaccion_btu ?? '-' }} BTU</p>
          </div>
          <div class="col-md-3">
            <p><strong>Cap. Enfriamiento:</strong> {{ $equipo->capacidad_enfriamiento_btu ?? '-' }} BTU</p>
          </div>
          <div class="col-md-3">
            <p><strong>Masa Refrigerante:</strong> {{ $equipo->masa_refrigerante ?? '-' }} kg</p>
          </div>
          <div class="col-md-3">
            <p><strong>Tipo Refrigerante:</strong> {{ $equipo->tipo_refrigerante ?? '-' }}</p>
          </div>
        </div>
        <div class="row">
          <div class="col-md-3">
            <p><strong>Presión Mínima:</strong> {{ $equipo->presion_minima ?? '-' }} bar</p>
          </div>
          <div class="col-md-3">
            <p><strong>Presión Máxima:</strong> {{ $equipo->presion_maxima ?? '-' }} bar</p>
          </div>
        </div>

        <h6 class="text-primary mt-4 mb-3">Mantención</h6>
        <div class="row">
          <div class="col-md-4">
            <p><strong>Última Mantención:</strong> {{ $equipo->ultima_mantencion ? \Carbon\Carbon::parse($equipo->ultima_mantencion)->format('d-m-Y') : 'Sin registro' }}</p>
          </div>
          <div class="col-md-4">
            <p><strong>Próxima Mantención:</strong> {{ $equipo->proxima_mantencion ? \Carbon\Carbon::parse($equipo->proxima_mantencion)->format('d-m-Y') : 'Sin registro' }}</p>
          </div>
        </div>

        @if($equipo->observaciones)
        <div class="mt-4">
          <h6 class="text-primary mb-3">Observaciones</h6>
          <p>{{ $equipo->observaciones }}</p>
        </div>
        @endif
      </div>
    </div>
  </div>
</div>
@endsection