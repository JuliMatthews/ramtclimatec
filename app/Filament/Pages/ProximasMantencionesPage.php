<?php

namespace App\Filament\Pages;

use App\Models\Cliente;
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
        return Cliente::whereNotNull('proxima_mantencion')
            ->where('activo', true)
            ->orderBy('proxima_mantencion', 'asc')
            ->get()
            ->map(function ($cliente) {
                $dias = Carbon::today()->diffInDays(Carbon::parse($cliente->proxima_mantencion), false);
                $cliente->dias_restantes = $dias;
                $cliente->alerta = match (true) {
                    $dias < 0 => 'vencida',
                    $dias <= 15 => 'urgente',
                    $dias <= 30 => 'proximo',
                    default => 'ok',
                };

                return $cliente;
            });
    }
}
