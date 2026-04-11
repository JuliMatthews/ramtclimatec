@extends('admin.layout')

@section('title', 'Dashboard - Ramtclimatec')

@section('content')
<div class="row">
  <div class="col-12 grid-margin stretch-card">
    <div class="card" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
      <div class="card-body py-4 px-4">
        <div class="row align-items-center">
          <div class="col-12">
            <h4 class="mb-2 text-white">Bienvenido al panel de administración</h4>
            <p class="mb-0 text-white-50">Gestiona todos los recursos de tu empresa desde aquí</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-xl-3 col-sm-6 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <div class="row">
          <div class="col-9">
            <div class="d-flex align-items-center align-self-start">
              <h3 class="mb-0">{{ $stats['clientes'] }}</h3>
            </div>
          </div>
          <div class="col-3">
            <div class="icon icon-box-success">
              <span class="mdi mdi-account-group icon-item"></span>
            </div>
          </div>
        </div>
        <h6 class="text-muted font-weight-normal">Clientes</h6>
      </div>
    </div>
  </div>
  <div class="col-xl-3 col-sm-6 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <div class="row">
          <div class="col-9">
            <div class="d-flex align-items-center align-self-start">
              <h3 class="mb-0">{{ $stats['ordenes_trabajo'] }}</h3>
            </div>
          </div>
          <div class="col-3">
            <div class="icon icon-box-primary">
              <span class="mdi mdi-clipboard-text icon-item"></span>
            </div>
          </div>
        </div>
        <h6 class="text-muted font-weight-normal">Órdenes de Trabajo</h6>
      </div>
    </div>
  </div>
  <div class="col-xl-3 col-sm-6 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <div class="row">
          <div class="col-9">
            <div class="d-flex align-items-center align-self-start">
              <h3 class="mb-0">{{ $stats['equipos'] }}</h3>
            </div>
          </div>
          <div class="col-3">
            <div class="icon icon-box-warning">
              <span class="mdi mdi-air-conditioner icon-item"></span>
            </div>
          </div>
        </div>
        <h6 class="text-muted font-weight-normal">Equipos</h6>
      </div>
    </div>
  </div>
  <div class="col-xl-3 col-sm-6 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <div class="row">
          <div class="col-9">
            <div class="d-flex align-items-center align-self-start">
              <h3 class="mb-0">{{ $stats['materiales'] }}</h3>
            </div>
          </div>
          <div class="col-3">
            <div class="icon icon-box-info">
              <span class="mdi mdi-package-variant icon-item"></span>
            </div>
          </div>
        </div>
        <h6 class="text-muted font-weight-normal">Materiales</h6>
      </div>
    </div>
  </div>
</div>

<div class="row">
  @if($mantencionesVencidas->count() > 0)
  <div class="col-md-6 grid-margin stretch-card">
    <div class="card border border-danger">
      <div class="card-body">
        <h4 class="card-title text-danger">
          <i class="mdi mdi-alert-circle"></i> Mantenciones Vencidas
        </h4>
        <div class="table-responsive">
          <table class="table table-sm">
            <thead>
              <tr>
                <th>Equipo</th>
                <th>Cliente</th>
                <th>Fecha</th>
              </tr>
            </thead>
            <tbody>
              @foreach($mantencionesVencidas as $equipo)
              <tr>
                <td>{{ $equipo->marca }} {{ $equipo->modelo }}</td>
                <td>{{ $equipo->cliente->nombre ?? '-' }}</td>
                <td class="text-danger">{{ \Carbon\Carbon::parse($equipo->proxima_mantencion)->format('d/m/Y') }}</td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
        <a href="{{ route('admin.mantenciones.index') }}" class="btn btn-outline-danger btn-sm mt-2">Ver todas</a>
      </div>
    </div>
  </div>
  @endif
  
  <div class="col-md-{{ $mantencionesVencidas->count() > 0 ? '6' : '12' }} grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <h4 class="card-title">
          <i class="mdi mdi-calendar-clock"></i> Próximas Mantenciones (30 días)
        </h4>
        <div class="table-responsive">
          <table class="table table-sm">
            <thead>
              <tr>
                <th>Equipo</th>
                <th>Cliente</th>
                <th>Fecha</th>
                <th>Días</th>
              </tr>
            </thead>
            <tbody>
              @forelse($mantencionesProximas as $equipo)
              @php
                $dias = \Carbon\Carbon::today()->diffInDays($equipo->proxima_mantencion, false);
              @endphp
              <tr>
                <td>{{ $equipo->marca }} {{ $equipo->modelo }}</td>
                <td>{{ $equipo->cliente->nombre ?? '-' }}</td>
                <td>{{ \Carbon\Carbon::parse($equipo->proxima_mantencion)->format('d/m/Y') }}</td>
                <td>
                  @if($dias <= 7)
                    <span class="badge badge-danger">{{ $dias }} días</span>
                  @elseif($dias <= 15)
                    <span class="badge badge-warning">{{ $dias }} días</span>
                  @else
                    <span class="badge badge-info">{{ $dias }} días</span>
                  @endif
                </td>
              </tr>
              @empty
              <tr>
                <td colspan="4" class="text-center">No hay mantenciones próximas</td>
              </tr>
              @endforelse
            </tbody>
          </table>
        </div>
        <a href="{{ route('admin.mantenciones.index') }}" class="btn btn-outline-primary btn-sm mt-2">Ver todas</a>
      </div>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-md-8 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <h4 class="card-title">Órdenes de Trabajo Recientes</h4>
        <div class="table-responsive">
          <table class="table">
            <thead>
              <tr>
                <th>ID</th>
                <th>Cliente</th>
                <th>Estado</th>
                <th>Fecha</th>
              </tr>
            </thead>
            <tbody>
              @forelse($ordenesRecientes as $orden)
              <tr>
                <td>#{{ $orden->id }}</td>
                <td>{{ $orden->cliente->nombre ?? 'Sin cliente' }}</td>
                <td>
                  @switch($orden->estado)
                    @case('pendiente')
                      <span class="badge badge-warning">Pendiente</span>
                      @break
                    @case('en_proceso')
                      <span class="badge badge-info">En Proceso</span>
                      @break
                    @case('completada')
                      <span class="badge badge-success">Completada</span>
                      @break
                    @case('cancelada')
                      <span class="badge badge-danger">Cancelada</span>
                      @break
                    @default
                      <span class="badge badge-secondary">{{ $orden->estado }}</span>
                  @endswitch
                </td>
                <td>{{ $orden->created_at->format('d/m/Y') }}</td>
              </tr>
              @empty
              <tr>
                <td colspan="4" class="text-center">No hay órdenes de trabajo</td>
              </tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
  
  <div class="col-md-4 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <h4 class="card-title">
          <i class="mdi mdi-chart-bar"></i> Equipos por Marca
        </h4>
        @if($equiposPorMarca->count() > 0)
        <div class="mt-3">
          @foreach($equiposPorMarca as $marca)
          <div class="d-flex justify-content-between align-items-center mb-2">
            <span class="text-truncate" style="max-width: 60%;">{{ $marca->marca ?? 'Sin marca' }}</span>
            <span class="badge badge-primary">{{ $marca->total }}</span>
          </div>
          <div class="progress mb-3" style="height: 8px;">
            <div class="progress-bar" role="progressbar" style="width: {{ ($marca->total / $equiposPorMarca->max('total')) * 100 }}%"></div>
          </div>
          @endforeach
        </div>
        @else
        <p class="text-muted text-center">No hay equipos registrados</p>
        @endif
      </div>
    </div>
  </div>
</div>
@endsection