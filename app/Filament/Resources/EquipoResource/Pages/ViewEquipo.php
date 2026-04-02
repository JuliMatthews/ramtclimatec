<?php

namespace App\Filament\Resources\EquipoResource\Pages;

use App\Filament\Resources\EquipoResource;
use App\Models\Equipo;
use Filament\Actions\Action;
use Filament\Resources\Pages\ViewRecord;
use Filament\Infolists\Infolist;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\IconEntry;
use Illuminate\Database\Eloquent\Model;

class ViewEquipo extends ViewRecord
{
    protected static string $resource = EquipoResource::class;

    protected function resolveRecord($key): Model
    {
        return Equipo::query()->findOrFail($key);
    }

    public function getTitle(): string
    {
        return "Ficha Técnica: {$this->record->ubicacion}";
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('descargar_pdf')
                ->label('PDF')
                ->color('danger')
                ->icon('heroicon-o-document-arrow-down')
                ->url(fn () => route('equipo.pdf', $this->record))
                ->openUrlInNewTab(),
        ];
    }

    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist->schema([
            Section::make('Vinculación')
                ->schema([
                    TextEntry::make('cliente.nombre')->label('Cliente'),
                    TextEntry::make('direccion.calle')->label('Dirección'),
                    TextEntry::make('ubicacion')->label('Ubicación'),
                ])->columns(3),

            Section::make('Identificación del equipo')
                ->schema([
                    TextEntry::make('marca')->label('Marca'),
                    TextEntry::make('modelo')->label('Modelo'),
                    TextEntry::make('numero_serie')->label('N° de serie'),
                    TextEntry::make('pais_fabricacion')->label('País de fabricación'),
                    TextEntry::make('fecha_fabricacion')->label('Fecha de fabricación'),
                    IconEntry::make('activo')->label('Activo')->boolean(),
                ])->columns(3),

            Section::make('Datos eléctricos')
                ->schema([
                    TextEntry::make('tension_nominal')->label('Tensión nominal'),
                    TextEntry::make('frecuencia')->label('Frecuencia'),
                    TextEntry::make('potencia_calefaccion')->label('Potencia calefacción'),
                    TextEntry::make('potencia_enfriamiento')->label('Potencia enfriamiento'),
                ])->columns(4),

            Section::make('Capacidades y refrigerante')
                ->schema([
                    TextEntry::make('capacidad_calefaccion_btu')->label('Capacidad calefacción (BTU/h)'),
                    TextEntry::make('capacidad_enfriamiento_btu')->label('Capacidad enfriamiento (BTU/h)'),
                    TextEntry::make('tipo_refrigerante')->label('Tipo de refrigerante'),
                    TextEntry::make('masa_refrigerante')->label('Masa refrigerante (g)'),
                    TextEntry::make('presion_minima')->label('Presión mínima (MPa)'),
                    TextEntry::make('presion_maxima')->label('Presión máxima (MPa)'),
                ])->columns(3),

            Section::make('Mantención')
                ->schema([
                    TextEntry::make('ultima_mantencion')->label('Última mantención')->date('d/m/Y'),
                    TextEntry::make('proxima_mantencion')->label('Próxima mantención')->date('d/m/Y'),
                    TextEntry::make('observaciones')->label('Observaciones')->columnSpanFull(),
                ])->columns(2),
        ]);
    }
}