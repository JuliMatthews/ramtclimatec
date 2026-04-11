<?php

use App\Http\Controllers\Admin\ClienteController;
use App\Http\Controllers\Admin\OrdenTrabajoController;
use App\Http\Controllers\Admin\EquipoController;
use App\Http\Controllers\Admin\TecnicoController;
use App\Http\Controllers\Admin\MaterialController;
use App\Http\Controllers\Admin\AyudanteController;
use App\Http\Controllers\Admin\DireccionController;
use App\Http\Controllers\Admin\ErrorController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\MantencionController;
use App\Http\Controllers\OrdenTrabajoController as OrdenTrabajoPdfController;
use App\Models\Equipo;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/admin/dashboard');
});

// Rutas del panel de administración
Route::prefix('admin')->name('admin.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Recursos
    Route::resource('clientes', ClienteController::class);
    Route::resource('direcciones', DireccionController::class);
    Route::resource('ordenes_trabajo', OrdenTrabajoController::class);
    Route::resource('equipos', EquipoController::class);
    Route::get('/equipos/cliente/{cliente}', [EquipoController::class, 'porCliente'])->name('equipos.porCliente');
    Route::get('/equipos/cliente/{cliente}/pdf', [EquipoController::class, 'exportarPdf'])->name('equipos.exportarPdf');
    Route::get('/equipos/cliente/{cliente}/excel', [EquipoController::class, 'exportarExcel'])->name('equipos.exportarExcel');
    Route::resource('tecnicos', TecnicoController::class);
    Route::resource('materiales', MaterialController::class);
    Route::resource('ayudantes', AyudanteController::class);
    Route::resource('errores', ErrorController::class);
    
    // Rutas AJAX
    Route::get('/direcciones/cliente/{clienteId}', [DireccionController::class, 'porCliente']);
    
    // Mantenciones
    Route::get('/mantenciones', [MantencionController::class, 'index'])->name('mantenciones.index');
});

// Rutas de PDF
Route::get('/ot/{ot}/pdf', [OrdenTrabajoPdfController::class, 'generarPdf'])
    ->name('ot.pdf')
    ->middleware('auth');

Route::get('/equipo/{equipo}/pdf', function (Equipo $equipo) {
    $pdf = Pdf::loadView('pdf.ficha_equipo', compact('equipo'));
    return $pdf->download("ficha_tecnica_{$equipo->ubicacion}.pdf");
})->name('equipo.pdf')->middleware('auth');