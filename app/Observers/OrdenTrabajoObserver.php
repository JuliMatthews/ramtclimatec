<?php

namespace App\Observers;

use App\Models\OrdenTrabajo;
use Illuminate\Support\Carbon;

class OrdenTrabajoObserver
{
    public function updated(OrdenTrabajo $ordenTrabajo): void
    {
        // Solo actuar si es tipo mantención, está completada y tiene fecha_termino
        if (
            $ordenTrabajo->tipo_servicio === 'mantencion' &&
            $ordenTrabajo->estado === 'completada' &&
            $ordenTrabajo->fecha_termino
        ) {
            $proximaMantencion = Carbon::parse($ordenTrabajo->fecha_termino)->addMonths(3);

            $ordenTrabajo->cliente->update([
                'proxima_mantencion' => $proximaMantencion->toDateString(),
            ]);
        }
    }
}
