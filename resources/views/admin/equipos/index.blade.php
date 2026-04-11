@extends('admin.layout')

@section('title', 'Equipos - Ramtclimatec')

@section('content')
<div class="row">
  <div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-4">
          <h4 class="card-title">Equipos por Cliente</h4>
        </div>
        
        @if(session('success'))
        <div class="alert alert-success">
          {{ session('success') }}
        </div>
        @endif

        <div class="table-responsive">
          <table class="table">
            <thead>
              <tr>
                <th>Cliente</th>
                <th>Tipo</th>
                <th>Comuna</th>
                <th>Correo</th>
                <th>Teléfono</th>
                <th>Equipos</th>
                <th>Acción</th>
              </tr>
            </thead>
            <tbody>
              @forelse($clientesConEquipos as $cliente)
              <tr>
                <td>{{ $cliente->nombre }}</td>
                <td>{{ $cliente->tipo ?? 'Empresa' }}</td>
                <td>{{ $cliente->direcciones->first()->comuna ?? '-' }}</td>
                <td>{{ $cliente->email ?? '-' }}</td>
                <td>{{ $cliente->telefono ?? '-' }}</td>
                <td>
                  <span class="badge badge-info">{{ $cliente->equipos->count() }}</span>
                </td>
                <td>
                  <a href="{{ route('admin.equipos.porCliente', $cliente->id) }}" class="btn btn-primary btn-sm">
                    <i class="mdi mdi-cog"></i> Ver Equipos
                  </a>
                </td>
              </tr>
              <tr id="equipos-{{ $cliente->id }}" style="display: none;">
                <td colspan="7" class="bg-light p-3">
                  <table class="table table-sm table-bordered mb-0">
                    <thead>
                      <tr>
                        <th>Marca</th>
                        <th>Modelo</th>
                        <th>Ubicación</th>
                        <th>N° Serie</th>
                        <th>Estado</th>
                        <th>Próxima Mantención</th>
                        <th>Acciones</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($cliente->equipos as $equipo)
                      <tr>
                        <td>{{ $equipo->marca ?? '-' }}</td>
                        <td>{{ $equipo->modelo ?? '-' }}</td>
                        <td>{{ $equipo->ubicacion ?? '-' }}</td>
                        <td>{{ $equipo->numero_serie ?? '-' }}</td>
                        <td>
                          @if($equipo->activo)
                            <span class="badge badge-success">Activo</span>
                          @else
                            <span class="badge badge-secondary">Inactivo</span>
                          @endif
                        </td>
                        <td>
                          @if($equipo->proxima_mantencion)
                            {{ \Carbon\Carbon::parse($equipo->proxima_mantencion)->format('d-m-Y') }}
                          @else
                            -
                          @endif
                        </td>
                        <td>
                          <a href="{{ route('admin.equipos.show', $equipo->id) }}" class="btn btn-info btn-sm">
                            <i class="mdi mdi-eye"></i>
                          </a>
                          <a href="{{ route('admin.equipos.edit', $equipo->id) }}" class="btn btn-warning btn-sm">
                            <i class="mdi mdi-pencil"></i>
                          </a>
                        </td>
                      </tr>
                      @endforeach
                    </tbody>
                  </table>
                </td>
              </tr>
              @empty
              <tr>
                <td colspan="7" class="text-center">No hay clientes con equipos registrados</td>
              </tr>
              @endforelse
            </tbody>
          </table>
        </div>
        
        <div class="mt-4 custom-pagination">
          {{ $clientesConEquipos->links('pagination.bootstrap-custom') }}
        </div>
      </div>
    </div>
  </div>
</div>
@endsection