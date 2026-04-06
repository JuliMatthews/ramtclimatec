<?php

use App\Http\Controllers\OrdenTrabajoController;
use App\Models\Equipo;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/panel');
});

Route::get('/ot/{ot}/pdf', [OrdenTrabajoController::class, 'generarPdf'])
    ->name('ot.pdf')
    ->middleware('auth');

Route::get('/equipo/{equipo}/pdf', function (Equipo $equipo) {
    $pdf = Pdf::loadView('pdf.ficha_equipo', compact('equipo'));

    return $pdf->download("ficha_tecnica_{$equipo->ubicacion}.pdf");
})->name('equipo.pdf')->middleware('auth');