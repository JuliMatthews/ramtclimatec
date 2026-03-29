<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: Arial, sans-serif; font-size: 14px; color: #333; margin: 0; padding: 0; background: #f3f4f6; }
        .container { max-width: 600px; margin: 30px auto; background: white; border-radius: 8px; overflow: hidden; }
        .header { background-color: #dbeafe; padding: 20px 30px; }
        .header h1 { color: #1e3a5f; font-size: 20px; margin: 0; }
        .header p { color: #4b6080; font-size: 13px; margin: 4px 0 0; }
        .body { padding: 30px; }
        .body p { line-height: 1.6; margin-bottom: 12px; }
        .ot-box { background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 6px; padding: 15px 20px; margin: 20px 0; }
        .ot-box p { margin: 4px 0; font-size: 13px; }
        .ot-box strong { color: #1e3a5f; }
        .footer { background: #f1f5f9; padding: 15px 30px; text-align: center; font-size: 12px; color: #94a3b8; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Ramtclimatec SPA</h1>
            <p>Orden de Trabajo adjunta</p>
        </div>
        <div class="body">
            <p>Estimado equipo,</p>
            <p>Se adjunta la Orden de Trabajo con los siguientes detalles:</p>

            <div class="ot-box">
                <p><strong>N° OT:</strong> #{{ str_pad($ot->id, 4, '0', STR_PAD_LEFT) }}</p>
                <p><strong>Cliente:</strong> {{ $ot->cliente->nombre }}</p>
                <p><strong>Servicio:</strong> {{ match($ot->tipo_servicio) {
                    'primera_visita' => 'Primera visita (Gratis)',
                    'instalacion'    => 'Instalación',
                    'mantencion'     => 'Mantención',
                    'reparacion'     => 'Reparación',
                    'diagnostico'    => 'Diagnóstico',
                    'garantia'       => 'Garantía',
                    default          => $ot->tipo_servicio
                } }}</p>
                <p><strong>Estado:</strong> {{ match($ot->estado) {
                    'pendiente'   => 'Pendiente',
                    'en_progreso' => 'En Progreso',
                    'completada'  => 'Completada',
                    'cancelada'   => 'Cancelada',
                    default       => $ot->estado
                } }}</p>
                <p><strong>Fecha inicio:</strong> {{ $ot->fecha_inicio?->format('d/m/Y') ?? '—' }}</p>
                <p><strong>Fecha término:</strong> {{ $ot->fecha_termino?->format('d/m/Y') ?? '—' }}</p>
            </div>

            <p>El documento PDF con todos los detalles se encuentra adjunto a este correo.</p>
            <p>Saludos,<br><strong>Sistema Ramtclimatec</strong></p>
        </div>
        <div class="footer">
            Este correo fue generado automáticamente por el sistema de Ramtclimatec SPA.
        </div>
    </div>
</body>
</html>