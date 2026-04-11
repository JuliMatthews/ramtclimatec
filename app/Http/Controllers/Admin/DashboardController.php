<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cliente;
use App\Models\OrdenTrabajo;
use App\Models\Equipo;
use App\Models\Material;
use App\Models\Tecnico;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        $stats = [
            'clientes' => Cliente::count(),
            'ordenes_trabajo' => OrdenTrabajo::count(),
            'equipos' => Equipo::count(),
            'materiales' => Material::count(),
            'tecnicos' => Tecnico::count(),
        ];
        
        $ordenesRecientes = OrdenTrabajo::with('cliente')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();
        
        $hoy = Carbon::today();
        $prox30 = Carbon::today()->addDays(30);
        
        $mantencionesProximas = Equipo::with('cliente')
            ->whereNotNull('proxima_mantencion')
            ->whereBetween('proxima_mantencion', [$hoy, $prox30])
            ->orderBy('proxima_mantencion')
            ->take(10)
            ->get();
        
        $mantencionesVencidas = Equipo::with('cliente')
            ->whereNotNull('proxima_mantencion')
            ->where('proxima_mantencion', '<', $hoy)
            ->orderBy('proxima_mantencion')
            ->take(5)
            ->get();
        
        $equiposPorMarca = Equipo::select('marca')
            ->selectRaw('count(*) as total')
            ->whereNotNull('marca')
            ->groupBy('marca')
            ->orderByDesc('total')
            ->limit(10)
            ->get();
        
        return view('admin.dashboard', compact(
            'stats', 
            'ordenesRecientes', 
            'user',
            'mantencionesProximas',
            'mantencionesVencidas',
            'equiposPorMarca'
        ));
    }
}