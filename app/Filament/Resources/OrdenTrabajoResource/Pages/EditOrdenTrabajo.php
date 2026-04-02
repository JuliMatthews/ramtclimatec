<?php

namespace App\Filament\Resources\OrdenTrabajoResource\Pages;

use App\Filament\Resources\OrdenTrabajoResource;
use App\Models\Equipo;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Carbon;
use Illuminate\Validation\ValidationException;

class EditOrdenTrabajo extends EditRecord
{
    protected static string $resource = OrdenTrabajoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $data['equipos_intervenidos'] = $this->record->equipos->map(function ($equipo) {
            return [
                'equipo_id'          => $equipo->id,
                'estado_final'       => $equipo->pivot->estado_final,
                'trabajo_realizado'  => $equipo->pivot->trabajo_realizado,
                'presion_alta'       => $equipo->pivot->presion_alta,
                'presion_baja'       => $equipo->pivot->presion_baja,
                'temperatura_salida' => $equipo->pivot->temperatura_salida,
                'amperaje'           => $equipo->pivot->amperaje,
            ];
        })->toArray();

        return $data;
    }

    protected function beforeSave(): void
    {
        $data = $this->form->getRawState();

        // ✅ Validación 1: No permitir "Completada" sin fecha_termino
        if ($data['estado'] === 'completada' && empty($data['fecha_termino'])) {
            Notification::make()
                ->title('Falta fecha de término')
                ->body('No puedes marcar una OT como Completada sin ingresar la fecha de término.')
                ->danger()
                ->send();

            $this->halt();
        }

        // ✅ Validación 2: fecha_termino no puede ser anterior a fecha_inicio
        if (!empty($data['fecha_inicio']) && !empty($data['fecha_termino'])) {
            $inicio  = Carbon::parse($data['fecha_inicio']);
            $termino = Carbon::parse($data['fecha_termino']);

            if ($termino->lt($inicio)) {
                Notification::make()
                    ->title('Fechas inválidas')
                    ->body('La fecha de término no puede ser anterior a la fecha de inicio.')
                    ->danger()
                    ->send();

                $this->halt();
            }
        }

        // ✅ Validación 3: Al menos 1 equipo intervenido
        if (empty($data['equipos_intervenidos'])) {
            Notification::make()
                ->title('Sin equipos intervenidos')
                ->body('Debes agregar al menos un equipo intervenido antes de guardar.')
                ->danger()
                ->send();

            $this->halt();
        }
    }

    protected function afterSave(): void
    {
        $data = $this->form->getRawState();

        $equipos = collect($data['equipos_intervenidos'] ?? [])->mapWithKeys(function ($item) {
            return [$item['equipo_id'] => [
                'estado_final'       => $item['estado_final'],
                'trabajo_realizado'  => $item['trabajo_realizado'],
                'presion_alta'       => $item['presion_alta'],
                'presion_baja'       => $item['presion_baja'],
                'temperatura_salida' => $item['temperatura_salida'],
                'amperaje'           => $item['amperaje'],
            ]];
        });

        $this->record->equipos()->sync($equipos);

        // ✅ Validación 4: Al completar OT → actualizar ultima_mantencion del equipo
        if ($this->record->estado === 'completada' && $this->record->fecha_termino) {
            foreach ($equipos as $equipoId => $pivotData) {
                $equipo = Equipo::find($equipoId);
                if ($equipo) {
                    $equipo->ultima_mantencion = Carbon::parse($this->record->fecha_termino)->toDateString();
                    $equipo->save();
                }
            }
        }
    }
}