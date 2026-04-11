<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Equipos - {{ $cliente->nombre }}</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 10px; }
        h1 { font-size: 18px; margin-bottom: 5px; }
        .header-info { margin-bottom: 15px; }
        .header-info p { margin: 2px 0; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; font-size: 9px; }
        th, td { border: 1px solid #ddd; padding: 4px; text-align: left; }
        th { background-color: #4B49AC; color: white; }
        tr:nth-child(even) { background-color: #f9f9f9; }
        .badge { padding: 2px 6px; border-radius: 3px; font-size: 8px; }
        .badge-success { background: #28a745; color: white; }
        .badge-secondary { background: #6c757d; color: white; }
    </style>
</head>
<body>
    <h1>Equipos de: {{ $cliente->nombre }}</h1>
    <div class="header-info">
        <p><strong>RUT:</strong> {{ $cliente->rut }}</p>
        <p><strong>Dirección:</strong> {{ $cliente->direcciones->first()->direccion_completa ?? 'Sin dirección' }}</p>
        <p><strong>Teléfono:</strong> {{ $cliente->telefono ?? '-' }}</p>
        <p><strong>Email:</strong> {{ $cliente->email ?? '-' }}</p>
    </div>
    
    <table>
        <thead>
            <tr>
                <th>Marca</th>
                <th>Modelo</th>
                <th>N° Serie</th>
                <th>Ubicación</th>
                <th>Tipo</th>
                <th>País</th>
                <th>Tensión</th>
                <th>Frecuencia</th>
                <th>Pot. Calor</th>
                <th>Pot. Frío</th>
                <th>BTU Calor</th>
                <th>BTU Frío</th>
                <th>Refrigerante</th>
                <th>Masa (kg)</th>
                <th>P. Mín</th>
                <th>P. Máx</th>
                <th>Últ. Mant.</th>
                <th>Próx. Mant.</th>
                <th>Estado</th>
            </tr>
        </thead>
        <tbody>
            @foreach($cliente->equipos as $equipo)
            <tr>
                <td>{{ $equipo->marca ?? '-' }}</td>
                <td>{{ $equipo->modelo ?? '-' }}</td>
                <td>{{ $equipo->numero_serie ?? '-' }}</td>
                <td>{{ $equipo->ubicacion ?? '-' }}</td>
                <td>{{ $equipo->tipo_equipo ?? '-' }}</td>
                <td>{{ $equipo->pais_fabricacion ?? '-' }}</td>
                <td>{{ $equipo->tension_nominal ?? '-' }}</td>
                <td>{{ $equipo->frecuencia ?? '-' }}</td>
                <td>{{ $equipo->potencia_calefaccion ?? '-' }}</td>
                <td>{{ $equipo->potencia_enfriamiento ?? '-' }}</td>
                <td>{{ $equipo->capacidad_calefaccion_btu ?? '-' }}</td>
                <td>{{ $equipo->capacidad_enfriamiento_btu ?? '-' }}</td>
                <td>{{ $equipo->tipo_refrigerante ?? '-' }}</td>
                <td>{{ $equipo->masa_refrigerante ?? '-' }}</td>
                <td>{{ $equipo->presion_minima ?? '-' }}</td>
                <td>{{ $equipo->presion_maxima ?? '-' }}</td>
                <td>{{ $equipo->ultima_mantencion ? \Carbon\Carbon::parse($equipo->ultima_mantencion)->format('d-m-Y') : '-' }}</td>
                <td>{{ $equipo->proxima_mantencion ? \Carbon\Carbon::parse($equipo->proxima_mantencion)->format('d-m-Y') : '-' }}</td>
                <td>
                    @if($equipo->activo)
                        <span class="badge badge-success">Activo</span>
                    @else
                        <span class="badge badge-secondary">Inactivo</span>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>