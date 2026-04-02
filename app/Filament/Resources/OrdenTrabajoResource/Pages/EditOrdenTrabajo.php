<?php

namespace App\Filament\Resources\OrdenTrabajoResource\Pages;

use App\Filament\Resources\OrdenTrabajoResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditOrdenTrabajo extends EditRecord
{
    protected static string $resource = OrdenTrabajoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    // Carga los datos de la tabla pivote al abrir el formulario
    protected function mutateFormDataBeforeFill(array $data): array
    {
        $data['equipos_intervenidos'] = $this->record->equipos->map(function ($equipo) {
            return [
                'equipo_id' => $equipo->id,
                'estado_final' => $equipo->pivot->estado_final,
                'trabajo_realizado' => $equipo->pivot->trabajo_realizado,
                'presion_alta' => $equipo->pivot->presion_alta,
                'presion_baja' => $equipo->pivot->presion_baja,
                'temperatura_salida' => $equipo->pivot->temperatura_salida,
                'amperaje' => $equipo->pivot->amperaje,
            ];
        })->toArray();

        return $data;
    }

    // Guarda los datos en la tabla pivote al hacer clic en Guardar
    protected function afterSave(): void
    {
        $data = $this->form->getRawState();
        
        $equipos = collect($data['equipos_intervenidos'] ?? [])->mapWithKeys(function ($item) {
            return [$item['equipo_id'] => [
                'estado_final' => $item['estado_final'],
                'trabajo_realizado' => $item['trabajo_realizado'],
                'presion_alta' => $item['presion_alta'],
                'presion_baja' => $item['presion_baja'],
                'temperatura_salida' => $item['temperatura_salida'],
                'amperaje' => $item['amperaje'],
            ]];
        });

        // Guardar la relación en la tabla pivote
        $this->record->equipos()->sync($equipos);

        // 🚀 Actualización inteligente de fechas
        if ($this->record->estado === 'completada' && $this->record->fecha_termino) {
            foreach ($equipos as $equipoId => $pivotData) {
                $equipo = \App\Models\Equipo::find($equipoId);
                if ($equipo) {
                    // Al asignar esto, el modelo Equipo (gracias al booted) calculará los +6 meses
                    $equipo->ultima_mantencion = \Illuminate\Support\Carbon::parse($this->record->fecha_termino)->toDateString();
                    $equipo->save(); 
                }
            }
        }
    }
}