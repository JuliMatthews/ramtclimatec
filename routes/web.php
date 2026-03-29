<?php

use App\Http\Controllers\OrdenTrabajoController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/admin');
});

Route::get('/ot/{ot}/pdf', [OrdenTrabajoController::class, 'pdf'])
    ->name('ot.pdf')
    ->middleware('auth');