<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Equipo;
use Illuminate\Http\Request;

class MantencionController extends Controller
{
    public function index()
    {
        $equipos = Equipo::with('cliente')
            ->whereNotNull('proxima_mantencion')
            ->orderBy('proxima_mantencion')
            ->paginate(10);

        return view('admin.mantenciones.index', compact('equipos'));
    }
}