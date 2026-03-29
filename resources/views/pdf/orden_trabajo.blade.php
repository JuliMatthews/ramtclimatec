<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Orden de Trabajo #{{ $ot->id }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; font-size: 11px; color: #333; }

        /* HEADER */
        .header { background-color: #dbeafe; padding: 12px 20px; }
        .header-inner { display: flex; justify-content: space-between; align-items: center; }
        .header img { height: 38px; }
        .header-right { text-align: right; }
        .ot-number { font-size: 20px; font-weight: bold; color: #1e3a5f; }
        .header-right p { font-size: 10px; color: #4b6080; margin-top: 2px; }
        .badge { display: inline-block; padding: 3px 10px; border-radius: 4px; font-size: 10px; font-weight: bold; margin-top: 4px; }
        .badge-pendiente   { background: #fef3c7; color: #92400e; }
        .badge-en_progreso { background: #bfdbfe; color: #1e40af; }
        .badge-completada  { background: #d1fae5; color: #065f46; }
        .badge-cancelada   { background: #fee2e2; color: #991b1b; }

        /* CONTENIDO */
        .content { padding: 12px 20px; }
        .section { margin-bottom: 10px; border: 1px solid #e5e7eb; border-radius: 5px; overflow: hidden; }
        .section-title { background: #f1f5f9; padding: 5px 12px; font-weight: bold; font-size: 10px; text-transform: uppercase; color: #64748b; border-bottom: 1px solid #e5e7eb; letter-spacing: 0.5px; }
        .section-body { padding: 10px 12px; }

        /* GRIDS */
        .grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 8px; }
        .grid-4 { display: grid; grid-template-columns: 1fr 1fr 1fr 1fr; gap: 8px; }

        /* CAMPOS */
        .field { margin-bottom: 5px; }
        .field label { font-size: 9px; color: #94a3b8; text-transform: uppercase; display: block; margin-bottom: 1px; letter-spacing: 0.4px; }
        .field span { font-size: 11px; color: #111; font-weight: 500; }

        /* DESCRIPCION */
        .descripcion { background: #f8fafc; padding: 8px; border-radius: 3px; font-size: 11px; line-height: 1.5; margin-top: 8px; border: 1px solid #e2e8f0; }

        /* TABLAS */
        table { width: 100%; border-collapse: collapse; }
        table th { background: #f1f5f9; padding: 6px 8px; text-align: left; font-size: 10px; color: #64748b; border-bottom: 1px solid #e2e8f0; }
        table td { padding: 6px 8px; border-bottom: 1px solid #f1f5f9; font-size: 11px; }
        table tr:last-child td { border-bottom: none; }
        .total-row td { font-weight: bold; background: #f8fafc; border-top: 1px solid #e2e8f0; }

        /* FIRMAS */
        .firmas { display: grid; grid-template-columns: 1fr 1fr; gap: 40px; margin-top: 16px; }
        .firma { text-align: center; }
        .firma-linea { border-top: 1px solid #94a3b8; margin-bottom: 4px; padding-top: 4px; }
        .firma p { font-size: 10px; color: #64748b; }
        .text-muted { color: #94a3b8; }
    </style>
</head>
<body>

    {{-- HEADER --}}
    <div class="header">
        <div class="header-inner">
            <img src="{{ public_path('logo_ramt.png') }}" alt="Ramtclimatec">
            <div class="header-right">
                <div class="ot-number">OT #{{ str_pad($ot->id, 4, '0', STR_PAD_LEFT) }}</div>
                <p>Fecha emisión: {{ now()->format('d/m/Y') }}</p>
                <span class="badge badge-{{ $ot->estado }}">
                    {{ match($ot->estado) {
                        'pendiente'   => 'Pendiente',
                        'en_progreso' => 'En Progreso',
                        'completada'  => 'Completada',
                        'cancelada'   => 'Cancelada',
                        default       => $ot->estado
                    } }}
                </span>
            </div>
        </div>
    </div>

    <div class="content">

        {{-- CLIENTE --}}
        <div class="section">
            <div class="section-title">Datos del cliente</div>
            <div class="section-body">
                <div class="grid-2">
                    <div>
                        <div class="field"><label>Nombre</label><span>{{ $ot->cliente->nombre }}</span></div>
                        <div class="field"><label>RUT</label><span>{{ $ot->cliente->rut }}</span></div>
                    </div>
                    <div>
                        <div class="field"><label>Teléfono</label><span>{{ $ot->cliente->telefono ?? '—' }}</span></div>
                        <div class="field"><label>Correo</label><span>{{ $ot->cliente->email ?? '—' }}</span></div>
                    </div>
                </div>
            </div>
        </div>

        {{-- DIRECCIÓN --}}
        <div class="section">
            <div class="section-title">Dirección del servicio</div>
            <div class="section-body">
                <div class="grid-2">
                    <div class="field"><label>Calle y número</label><span>{{ $ot->direccion->calle }} {{ $ot->direccion->numero }}</span></div>
                    <div class="field"><label>Comuna</label><span>{{ $ot->direccion->comuna ?? '—' }}</span></div>
                    <div class="field"><label>Región</label><span>{{ $ot->direccion->region ?? '—' }}</span></div>
                    @if($ot->direccion->referencia)
                    <div class="field"><label>Referencia</label><span>{{ $ot->direccion->referencia }}</span></div>
                    @endif
                </div>
            </div>
        </div>

        {{-- DETALLE DEL SERVICIO --}}
        <div class="section">
            <div class="section-title">Detalle del servicio</div>
            <div class="section-body">
                <table style="width:100%; border-collapse: collapse;">
                    <tr>
                        <td style="font-size:9px; color:#94a3b8; text-transform:uppercase; padding-bottom:2px; width:25%">Tipo de servicio</td>
                        <td style="font-size:9px; color:#94a3b8; text-transform:uppercase; padding-bottom:2px; width:25%">Estado</td>
                        <td style="font-size:9px; color:#94a3b8; text-transform:uppercase; padding-bottom:2px; width:25%">Fecha inicio</td>
                        <td style="font-size:9px; color:#94a3b8; text-transform:uppercase; padding-bottom:2px; width:25%">Fecha término</td>
                    </tr>
                    <tr>
                        <td style="font-size:11px; font-weight:bold; padding-bottom:8px;">{{ match($ot->tipo_servicio) {
                            'primera_visita' => 'Primera visita',
                            'instalacion'    => 'Instalación',
                            'mantencion'     => 'Mantención',
                            'reparacion'     => 'Reparación',
                            'diagnostico'    => 'Diagnóstico',
                            'garantia'       => 'Garantía',
                            default          => $ot->tipo_servicio
                        } }}</td>
                        <td style="font-size:11px; font-weight:bold; padding-bottom:8px;">{{ match($ot->estado) {
                            'pendiente'   => 'Pendiente',
                            'en_progreso' => 'En Progreso',
                            'completada'  => 'Completada',
                            'cancelada'   => 'Cancelada',
                            default       => $ot->estado
                        } }}</td>
                        <td style="font-size:11px; font-weight:bold; padding-bottom:8px;">{{ $ot->fecha_inicio?->format('d/m/Y') ?? '—' }}</td>
                        <td style="font-size:11px; font-weight:bold; padding-bottom:8px;">{{ $ot->fecha_termino?->format('d/m/Y') ?? '—' }}</td>
                    </tr>
                </table>
                @if($ot->descripcion)
                <div class="descripcion">{{ $ot->descripcion }}</div>
                @endif
            </div>
        </div>

        {{-- TÉCNICOS --}}
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

        {{-- AYUDANTES --}}
        @if($ot->ayudantes->count() > 0)
        <div class="section">
            <div class="section-title">Ayudantes asignados</div>
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
                        @foreach($ot->ayudantes as $ayudante)
                        <tr>
                            <td>{{ $ayudante->nombre }}</td>
                            <td>{{ $ayudante->rut ?? '—' }}</td>
                            <td>{{ $ayudante->telefono ?? '—' }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endif

        {{-- MATERIALES --}}
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

        {{-- OBSERVACIONES --}}
        @if($ot->observaciones)
        <div class="section">
            <div class="section-title">Observaciones</div>
            <div class="section-body">
                <div class="descripcion">{{ $ot->observaciones }}</div>
            </div>
        </div>
        @endif

        {{-- FIRMAS --}}
        <div class="firmas">
            <div class="firma">
                <div style="height: 45px"></div>
                <div class="firma-linea"></div>
                <p><strong>Técnico responsable</strong></p>
                <p class="text-muted">Nombre y firma</p>
            </div>
            <div class="firma">
                <div style="height: 45px"></div>
                <div class="firma-linea"></div>
                <p><strong>Cliente</strong></p>
                <p class="text-muted">Nombre, firma y RUT</p>
            </div>
        </div>

    </div>
</body>
</html>