<?php

namespace App\Filament\Pages;

use App\Models\Equipo;
use Filament\Pages\Page;
use Illuminate\Support\Carbon;

class ProximasMantencionesPage extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-wrench-screwdriver';

    protected static ?string $navigationLabel = 'Próximas Mantenciones';

    protected static ?string $title = 'Próximas Mantenciones';

    protected static ?int $navigationSort = 7;

    protected static string $view = 'filament.pages.proximas-mantenciones-page';

    public function getClientes()
{
    return Equipo::whereNotNull('proxima_mantencion')
        ->where('activo', true)
        ->orderBy('proxima_mantencion', 'asc')
        ->get()
        ->map(function ($equipo) {
            $dias = Carbon::today()->diffInDays(Carbon::parse($equipo->proxima_mantencion), false);

            $equipo->dias_restantes = $dias;

            $equipo->alerta = match (true) {
                $dias < 0 => 'vencida',
                $dias <= 15 => 'urgente',
                $dias <= 30 => 'proximo',
                default => 'ok',
            };

            $equipo->cliente_nombre = $equipo->cliente?->nombre;
            $equipo->equipo_info = trim("{$equipo->marca} {$equipo->modelo}") ?: 'Sin información';

        return $equipo;
        });
}
}
