<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orden de Trabajo #{{ $ot->id }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; font-size: 12px; color: #333; }
        .header { background-color: #1a1a2e; color: white; padding: 20px; display: flex; justify-content: space-between; align-items: center; }
        .header img { height: 50px; }
        .header-right { text-align: right; }
        .header-right h1 { font-size: 20px; margin-bottom: 5px; }
        .header-right p { font-size: 11px; opacity: 0.8; }
        .badge { display: inline-block; padding: 4px 10px; border-radius: 4px; font-size: 11px; font-weight: bold; }
        .badge-pendiente { background: #fef3c7; color: #92400e; }
        .badge-en_progreso { background: #dbeafe; color: #1e40af; }
        .badge-completada { background: #d1fae5; color: #065f46; }
        .badge-cancelada { background: #fee2e2; color: #991b1b; }
        .content { padding: 20px; }
        .section { margin-bottom: 20px; border: 1px solid #e5e7eb; border-radius: 6px; overflow: hidden; }
        .section-title { background: #f3f4f6; padding: 8px 15px; font-weight: bold; font-size: 11px; text-transform: uppercase; color: #6b7280; border-bottom: 1px solid #e5e7eb; }
        .section-body { padding: 15px; }
        .grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 10px; }
        .grid-3 { display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 10px; }
        .field { margin-bottom: 8px; }
        .field label { font-size: 10px; color: #6b7280; text-transform: uppercase; display: block; margin-bottom: 2px; }
        .field span { font-size: 12px; color: #111; font-weight: 500; }
        table { width: 100%; border-collapse: collapse; }
        table th { background: #f3f4f6; padding: 8px; text-align: left; font-size: 11px; color: #6b7280; border-bottom: 2px solid #e5e7eb; }
        table td { padding: 8px; border-bottom: 1px solid #f3f4f6; font-size: 12px; }
        table tr:last-child td { border-bottom: none; }
        .total-row td { font-weight: bold; background: #f9fafb; border-top: 2px solid #e5e7eb; }
        .footer { margin-top: 30px; padding: 20px; border-top: 1px solid #e5e7eb; }
        .firmas { display: grid; grid-template-columns: 1fr 1fr; gap: 40px; margin-top: 20px; }
        .firma { text-align: center; }
        .firma-linea { border-top: 1px solid #333; margin-bottom: 5px; padding-top: 5px; }
        .firma p { font-size: 11px; color: #6b7280; }
        .ot-number { font-size: 28px; font-weight: bold; }
        .text-muted { color: #6b7280; }
        .descripcion { background: #f9fafb; padding: 10px; border-radius: 4px; font-size: 12px; line-height: 1.5; }
    </style>
</head>
<body>

    {{-- Header --}}
    <div class="header">
        <img src="{{ public_path('logo_ramt.png') }}" alt="Ramtclimatec">
        <div class="header-right">
            <div class="ot-number">OT #{{ str_pad($ot->id, 4, '0', STR_PAD_LEFT) }}</div>
            <p>Fecha emisión: {{ now()->format('d/m/Y') }}</p>
            <p>
                <span class="badge badge-{{ $ot->estado }}">
                    {{ match($ot->estado) {
                        'pendiente'   => 'Pendiente',
                        'en_progreso' => 'En Progreso',
                        'completada'  => 'Completada',
                        'cancelada'   => 'Cancelada',
                        default       => $ot->estado
                    } }}
                </span>
            </p>
        </div>
    </div>

    <div class="content">

        {{-- Cliente --}}
        <div class="section">
            <div class="section-title">Datos del cliente</div>
            <div class="section-body">
                <div class="grid-2">
                    <div>
                        <div class="field">
                            <label>Nombre</label>
                            <span>{{ $ot->cliente->nombre }}</span>
                        </div>
                        <div class="field">
                            <label>RUT</label>
                            <span>{{ $ot->cliente->rut }}</span>
                        </div>
                    </div>
                    <div>
                        <div class="field">
                            <label>Teléfono</label>
                            <span>{{ $ot->cliente->telefono ?? '—' }}</span>
                        </div>
                        <div class="field">
                            <label>Correo</label>
                            <span>{{ $ot->cliente->email ?? '—' }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Dirección --}}
        <div class="section">
            <div class="section-title">Dirección del servicio</div>
            <div class="section-body">
                <div class="grid-3">
                    <div class="field">
                        <label>Calle y número</label>
                        <span>{{ $ot->direccion->calle }} {{ $ot->direccion->numero }}</span>
                    </div>
                    <div class="field">
                        <label>Comuna</label>
                        <span>{{ $ot->direccion->comuna ?? '—' }}</span>
                    </div>
                    <div class="field">
                        <label>Región</label>
                        <span>{{ $ot->direccion->region ?? '—' }}</span>
                    </div>
                </div>
                @if($ot->direccion->referencia)
                <div class="field" style="margin-top: 8px">
                    <label>Referencia</label>
                    <span>{{ $ot->direccion->referencia }}</span>
                </div>
                @endif
            </div>
        </div>

        {{-- Servicio --}}
        <div class="section">
            <div class="section-title">Detalle del servicio</div>
            <div class="section-body">
                <div class="grid-2">
                    <div class="field">
                        <label>Tipo de servicio</label>
                        <span>{{ match($ot->tipo_servicio) {
                            'primera_visita' => 'Primera visita (Gratis)',
                            'instalacion'    => 'Instalación',
                            'mantencion'     => 'Mantención',
                            'reparacion'     => 'Reparación',
                            'diagnostico'    => 'Diagnóstico',
                            'garantia'       => 'Garantía',
                            default          => $ot->tipo_servicio
                        } }}</span>
                    </div>
                    <div class="field">
                        <label>Estado</label>
                        <span>{{ match($ot->estado) {
                            'pendiente'   => 'Pendiente',
                            'en_progreso' => 'En Progreso',
                            'completada'  => 'Completada',
                            'cancelada'   => 'Cancelada',
                            default       => $ot->estado
                        } }}</span>
                    </div>
                    <div class="field">
                        <label>Fecha inicio</label>
                        <span>{{ $ot->fecha_inicio?->format('d/m/Y') ?? '—' }}</span>
                    </div>
                    <div class="field">
                        <label>Fecha término</label>
                        <span>{{ $ot->fecha_termino?->format('d/m/Y') ?? '—' }}</span>
                    </div>
                </div>
                @if($ot->descripcion)
                <div class="field" style="margin-top: 10px">
                    <label>Descripción</label>
                    <div class="descripcion">{{ $ot->descripcion }}</div>
                </div>
                @endif
            </div>
        </div>

        {{-- Técnicos --}}
        @if($ot->tecnicos->count() > 0)
        <div class="section">
            <div class="section-title">Técnicos asignados</div>
            <div class="section-body">
                <table>
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>RUT</th>
                            <th>Teléfono</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($ot->tecnicos as $tecnico)
                        <tr>
                            <td>{{ $tecnico->nombre }}</td>
                            <td>{{ $tecnico->rut ?? '—' }}</td>
                            <td>{{ $tecnico->telefono ?? '—' }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endif

        {{-- Materiales --}}
        @if($ot->materiales->count() > 0)
        <div class="section">
            <div class="section-title">Materiales utilizados</div>
            <div class="section-body">
                <table>
                    <thead>
                        <tr>
                            <th>Material</th>
                            <th>Unidad</th>
                            <th>Cantidad</th>
                            <th>Precio unit.</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($ot->materiales as $item)
                        <tr>
                            <td>{{ $item->material->nombre }}</td>
                            <td>{{ $item->material->unidad }}</td>
                            <td>{{ $item->cantidad }}</td>
                            <td>${{ number_format($item->precio_unitario, 0, ',', '.') }}</td>
                            <td>${{ number_format($item->cantidad * $item->precio_unitario, 0, ',', '.') }}</td>
                        </tr>
                        @endforeach
                        <tr class="total-row">
                            <td colspan="4">Total materiales</td>
                            <td>${{ number_format($ot->materiales->sum(fn($i) => $i->cantidad * $i->precio_unitario), 0, ',', '.') }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        @endif

        {{-- Observaciones --}}
        @if($ot->observaciones)
        <div class="section">
            <div class="section-title">Observaciones</div>
            <div class="section-body">
                <div class="descripcion">{{ $ot->observaciones }}</div>
            </div>
        </div>
        @endif

        {{-- Firmas --}}
        <div class="footer">
            <div class="firmas">
                <div class="firma">
                    <div style="height: 50px"></div>
                    <div class="firma-linea"></div>
                    <p><strong>Técnico responsable</strong></p>
                    <p class="text-muted">Nombre y firma</p>
                </div>
                <div class="firma">
                    <div style="height: 50px"></div>
                    <div class="firma-linea"></div>
                    <p><strong>Cliente</strong></p>
                    <p class="text-muted">Nombre, firma y RUT</p>
                </div>
            </div>
        </div>

    </div>

</body>
</html>