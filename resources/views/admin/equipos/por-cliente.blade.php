@extends('admin.layout')

@section('title', 'Equipos de ' . $cliente->nombre . ' - Ramtclimatec')

@section('content')
<div class="row">
  <div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-4">
          <div>
            <h4 class="card-title">Equipos de: {{ $cliente->nombre }}</h4>
            <p class="text-muted mb-0">{{ $cliente->direcciones->first()->direccion_completa ?? 'Sin dirección' }}</p>
          </div>
          <div>
            <a href="{{ route('admin.equipos.exportarExcel', $cliente->id) }}" class="btn btn-success">
              <i class="mdi mdi-file-excel"></i> Xlsx
            </a>
            <a href="{{ route('admin.equipos.exportarPdf', $cliente->id) }}" class="btn btn-danger ml-2">
              <i class="mdi mdi-file-pdf-box"></i> PDF
            </a>
            <a href="{{ route('admin.equipos.create') }}" class="btn btn-primary ml-2">
              <i class="mdi mdi-plus"></i> Nuevo Equipo
            </a>
            <a href="{{ route('admin.equipos.index') }}" class="btn btn-secondary ml-2">
              <i class="mdi mdi-arrow-left"></i> Volver
            </a>
          </div>
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
                <th>Marca</th>
                <th>Modelo</th>
                <th>Ubicación</th>
                <th>BTU</th>
                <th>Refrigerante</th>
                <th>Última Mantención</th>
                <th>Próxima Mantención</th>
                <th>Acciones</th>
              </tr>
            </thead>
            <tbody>
              @forelse($cliente->equipos as $equipo)
              <tr>
                <td>{{ $equipo->marca ?? '-' }}</td>
                <td>{{ $equipo->modelo ?? '-' }}</td>
                <td>{{ $equipo->ubicacion ?? '-' }}</td>
                <td>{{ $equipo->capacidad_enfriamiento_btu ?? '-' }}</td>
                <td>{{ $equipo->tipo_refrigerante ?? '-' }}</td>
                <td>
                  @if($equipo->ultima_mantencion)
                    {{ \Carbon\Carbon::parse($equipo->ultima_mantencion)->format('d-m-Y') }}
                  @else
                    -
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
                  <form action="{{ route('admin.equipos.destroy', $equipo->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Eliminar este equipo?')">
                      <i class="mdi mdi-delete"></i>
                    </button>
                  </form>
                </td>
              </tr>
              @empty
              <tr>
                <td colspan="8" class="text-center">No hay equipos registrados</td>
              </tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection