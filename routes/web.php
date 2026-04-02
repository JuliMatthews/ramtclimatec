<?php

use App\Exports\EquiposPorClienteExport;
use App\Http\Controllers\OrdenTrabajoController;
use Illuminate\Support\Facades\Route;
use Maatwebsite\Excel\Facades\Excel;

Route::get('/', function () {
    return redirect('/panel');
});

Route::get('/ot/{ot}/pdf', [OrdenTrabajoController::class, 'generarPdf'])
    ->name('ot.pdf')
    ->middleware('auth');

Route::get('/export-equipos/{cliente}', function ($clienteId) {
    return Excel::download(
        new EquiposPorClienteExport($clienteId),
        "equipos_cliente_{$clienteId}.xlsx"
    );
})->name('export.equipos.cliente')->middleware('auth');