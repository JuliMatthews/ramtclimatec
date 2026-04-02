<?php

namespace App\Filament\Resources\OrdenTrabajoResource\Pages;

use App\Filament\Resources\OrdenTrabajoResource;
use Filament\Resources\Pages\CreateRecord;

class CreateOrdenTrabajo extends CreateRecord
{
    protected static string $resource = OrdenTrabajoResource::class;

    protected function afterCreate(): void
    {
        $data = $this->form->getRawState();
        
        if (!empty($data['equipos_intervenidos'])) {
            foreach ($data['equipos_intervenidos'] as $item) {
                $this->record->equipos()->attach($item['equipo_id'], [
                    'estado_final' => $item['estado_final'],
                    'trabajo_realizado' => $item['trabajo_realizado'],
                    'presion_alta' => $item['presion_alta'],
                    'presion_baja' => $item['presion_baja'],
                    'temperatura_salida' => $item['temperatura_salida'],
                    'amperaje' => $item['amperaje'],
                ]);
            }
        }
    }
}