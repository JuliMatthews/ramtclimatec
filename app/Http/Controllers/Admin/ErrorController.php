<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ErrorAire;
use Illuminate\Http\Request;

class ErrorController extends Controller
{
    public function index(Request $request)
    {
        $query = ErrorAire::query();

        if ($request->buscar) {
            $buscar = $request->buscar;
            $query->where(function ($q) use ($buscar) {
                $q->where('codigo', 'like', "%{$buscar}%")
                  ->orWhere('marca', 'like', "%{$buscar}%")
                  ->orWhere('error', 'like', "%{$buscar}%")
                  ->orWhere('causa', 'like', "%{$buscar}%")
                  ->orWhere('solucion', 'like', "%{$buscar}%");
            });
        }

        $errores = $query->orderBy('marca')->orderBy('codigo')->paginate(20);
        
        return view('admin.errores.index', compact('errores'));
    }
}