<?php

namespace App\Http\Controllers;

use App\Models\OrdenTrabajo;
use Barryvdh\DomPDF\Facade\Pdf;

class OrdenTrabajoController extends Controller
{
    public function pdf(OrdenTrabajo $ot)
    {
        $ot->load([
            'cliente',
            'direccion',
            'tecnicos',
            'ayudantes',
            'materiales.material',
        ]);

        $pdf = Pdf::loadView('pdf.orden_trabajo', compact('ot'))
            ->setPaper('a4', 'portrait');

        return $pdf->stream("OT-{$ot->id}.pdf");
    }
}
