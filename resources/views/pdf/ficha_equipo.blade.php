<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; color: #333; }
        h1 { font-size: 16px; color: #1a1a1a; margin-bottom: 4px; }
        .subtitulo { font-size: 11px; color: #666; margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 16px; }
        th { background-color: #f59e0b; color: white; text-align: left; padding: 6px 8px; font-size: 11px; }
        td { padding: 5px 8px; border-bottom: 1px solid #e5e7eb; }
        .seccion { font-weight: bold; font-size: 12px; margin: 14px 0 4px 0; color: #1a1a1a; border-bottom: 2px solid #f59e0b; padding-bottom: 2px; }
        .logo { text-align: right; margin-bottom: 10px; }
    </style>
</head>
<body>

    <div class="logo">
        <img src="{{ public_path('logo_ramt.png') }}" height="40">
    </div>

    <h1>Ficha Técnica: {{ $equipo->ubicacion }}</h1>
    <div class="subtitulo">Cliente: {{ $equipo->cliente->nombre }} &nbsp;|&nbsp; Generado el {{ now()->format('d/m/Y') }}</div>

    <div class="seccion">Vinculación</div>
    <table>
        <tr><th>Cliente</th><th>Dirección</th><th>Ubicación</th></tr>
        <tr>
            <td>{{ $equipo->cliente->nombre ?? '-' }}</td>
            <td>{{ $equipo->direccion->calle ?? '-' }}</td>
            <td>{{ $equipo->ubicacion ?? '-' }}</td>
        </tr>
    </table>

    <div class="seccion">Identificación del equipo</div>
    <table>
        <tr><th>Marca</th><th>Modelo</th><th>N° de serie</th></tr>
        <tr>
            <td>{{ $equipo->marca ?? '-' }}</td>
            <td>{{ $equipo->modelo ?? '-' }}</td>
            <td>{{ $equipo->numero_serie ?? '-' }}</td>
        </tr>
        <tr><th>País de fabricación</th><th>Fecha de fabricación</th><th>Activo</th></tr>
        <tr>
            <td>{{ $equipo->pais_fabricacion ?? '-' }}</td>
            <td>{{ $equipo->fecha_fabricacion ?? '-' }}</td>
            <td>{{ $equipo->activo ? 'Sí' : 'No' }}</td>
        </tr>
    </table>

    <div class="seccion">Datos eléctricos</div>
    <table>
        <tr><th>Tensión nominal</th><th>Frecuencia</th><th>Potencia calefacción</th><th>Potencia enfriamiento</th></tr>
        <tr>
            <td>{{ $equipo->tension_nominal ?? '-' }}</td>
            <td>{{ $equipo->frecuencia ?? '-' }}</td>
            <td>{{ $equipo->potencia_calefaccion ?? '-' }}</td>
            <td>{{ $equipo->potencia_enfriamiento ?? '-' }}</td>
        </tr>
    </table>

    <div class="seccion">Capacidades y refrigerante</div>
    <table>
        <tr><th>Cap. calefacción (BTU/h)</th><th>Cap. enfriamiento (BTU/h)</th><th>Tipo refrigerante</th></tr>
        <tr>
            <td>{{ $equipo->capacidad_calefaccion_btu ?? '-' }}</td>
            <td>{{ $equipo->capacidad_enfriamiento_btu ?? '-' }}</td>
            <td>{{ $equipo->tipo_refrigerante ?? '-' }}</td>
        </tr>
        <tr><th>Masa refrigerante (g)</th><th>Presión mínima (MPa)</th><th>Presión máxima (MPa)</th></tr>
        <tr>
            <td>{{ $equipo->masa_refrigerante ?? '-' }}</td>
            <td>{{ $equipo->presion_minima ?? '-' }}</td>
            <td>{{ $equipo->presion_maxima ?? '-' }}</td>
        </tr>
    </table>

    <div class="seccion">Mantención</div>
    <table>
        <tr><th>Última mantención</th><th>Próxima mantención</th></tr>
        <tr>
            <td>{{ $equipo->ultima_mantencion ? \Carbon\Carbon::parse($equipo->ultima_mantencion)->format('d/m/Y') : '-' }}</td>
            <td>{{ $equipo->proxima_mantencion ? \Carbon\Carbon::parse($equipo->proxima_mantencion)->format('d/m/Y') : '-' }}</td>
        </tr>
        @if($equipo->observaciones)
        <tr><th>Observaciones</th></tr>
        <tr><td>{{ $equipo->observaciones }}</td></tr>
        @endif
    </table>

</body>
</html>