@extends('admin.layout')

@section('title', 'Próximas Mantenciones - Ramtclimatec')

@section('content')
<div class="row">
  <div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <h4 class="card-title">Próximas Mantenciones</h4>
        
        <div class="table-responsive">
          <table class="table">
            <thead>
              <tr>
                <th>Equipo</th>
                <th>Ubicación</th>
                <th>Cliente</th>
                <th>Próxima Mantención</th>
                <th>Días restantes</th>
                <th>Estado</th>
                <th>Acción</th>
              </tr>
            </thead>
            <tbody>
              @forelse($equipos as $equipo)
              @php
                $diasRestantes = floor(\Carbon\Carbon::now()->diffInDays($equipo->proxima_mantencion, false));
                $claseEstado = $diasRestantes < 0 ? 'danger' : ($diasRestantes <= 30 ? 'warning' : 'success');
              @endphp
              <tr>
                <td>{{ $equipo->marca }} {{ $equipo->modelo }}</td>
                <td>{{ $equipo->ubicacion ?? '-' }}</td>
                <td>{{ $equipo->cliente->nombre ?? 'Sin cliente' }}</td>
                <td>{{ \Carbon\Carbon::parse($equipo->proxima_mantencion)->format('d-m-Y') }}</td>
                <td>
                  @if($diasRestantes < 0)
                    <span class="text-danger">{{ abs($diasRestantes) }} días vencido</span>
                  @else
                    {{ $diasRestantes }} días
                  @endif
                </td>
                <td>
                  <span class="badge badge-{{ $claseEstado }}">
                    @if($diasRestantes < 0)
                      Vencido
                    @elseif($diasRestantes <= 30)
                      Próximo
                    @else
                      Programado
                    @endif
                  </span>
                </td>
                <td>
                  <a href="{{ route('admin.equipos.edit', $equipo->id) }}" class="btn btn-primary btn-sm">
                    <i class="mdi mdi-clipboard-text"></i> Crear OT
                  </a>
                </td>
              </tr>
              @empty
              <tr>
                <td colspan="7" class="text-center">No hay mantenciones programadas</td>
              </tr>
              @endforelse
            </tbody>
          </table>
        </div>
        
        <div class="mt-4 custom-pagination">{{ $equipos->links('pagination.bootstrap-custom') }}</div>
      </div>
    </div>
  </div>
</div>
@endsection