<?php

namespace App\Filament\Widgets;

use App\Models\Equipo;
use App\Models\OrdenTrabajo;
use Carbon\Carbon;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $hoy = Carbon::today();

        $totalEquipos = Equipo::where('activo', true)->count();

        $vencidas = Equipo::where('activo', true)
            ->whereNotNull('proxima_mantencion')
            ->whereDate('proxima_mantencion', '<', $hoy)
            ->count();

        $proximas = Equipo::where('activo', true)
            ->whereNotNull('proxima_mantencion')
            ->whereDate('proxima_mantencion', '>=', $hoy)
            ->whereDate('proxima_mantencion', '<=', $hoy->copy()->addDays(30))
            ->count();

        $otEsteMes = OrdenTrabajo::whereMonth('created_at', $hoy->month)
            ->whereYear('created_at', $hoy->year)
            ->count();

        return [
            Stat::make('Total Equipos', $totalEquipos)
                ->description('Equipos activos')
                ->icon('heroicon-o-wrench-screwdriver')
                ->color('primary'),

            Stat::make('Mantenciones Vencidas', $vencidas)
                ->description('Requieren atención inmediata')
                ->icon('heroicon-o-exclamation-triangle')
                ->color('danger'),

            Stat::make('Próximas Mantenciones', $proximas)
                ->description('En los próximos 30 días')
                ->icon('heroicon-o-clock')
                ->color('warning'),

            Stat::make('OT este mes', $otEsteMes)
                ->description('Órdenes de trabajo ' . $hoy->translatedFormat('F Y'))
                ->icon('heroicon-o-clipboard-document-list')
                ->color('success'),
        ];
    }
}