@extends('admin.layout')

@section('title', 'Errores - Ramtclimatec')

@section('content')
<div class="row">
  <div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-4">
          <h4 class="card-title">Errores de Aires Acondicionados</h4>
        </div>
        
        <form method="GET" action="{{ route('admin.errores.index') }}" class="mb-4">
          <div class="row">
            <div class="col-md-10">
              <input type="text" name="buscar" class="form-control" placeholder="Buscar por código, marca, error, causa o solución..." value="{{ request('buscar') }}">
            </div>
            <div class="col-md-2">
              <button type="submit" class="btn btn-primary btn-block">
                <i class="mdi mdi-magnify"></i> Buscar
              </button>
            </div>
          </div>
        </form>
        
        @if(request('buscar'))
        <div class="mb-3">
          <span class="badge badge-info">Resultados para: "{{ request('buscar') }}"</span>
          <a href="{{ route('admin.errores.index') }}" class="btn btn-link btn-sm">Limpiar</a>
        </div>
        @endif

        <div class="table-responsive">
          <table class="table">
            <thead>
              <tr>
                <th>Código</th>
                <th>Marca</th>
                <th>Error</th>
                <th>Causa</th>
                <th>Solución</th>
              </tr>
            </thead>
            <tbody>
              @forelse($errores as $error)
              <tr>
                <td>{{ $error->codigo ?? '-' }}</td>
                <td>{{ $error->marca ?? '-' }}</td>
                <td>{{ $error->error }}</td>
                <td>{{ $error->causa ?? '-' }}</td>
                <td>{{ $error->solucion ?? '-' }}</td>
              </tr>
              @empty
              <tr>
                <td colspan="5" class="text-center">No se encontraron errores</td>
              </tr>
              @endforelse
            </tbody>
          </table>
        </div>
        
        <div class="mt-4 custom-pagination">{{ $errores->appends(request()->query())->links('pagination.bootstrap-custom') }}</div>
      </div>
    </div>
  </div>
</div>
@endsection