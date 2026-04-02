<?php

namespace App\Filament\Resources\EquipoResource\Pages;

use App\Filament\Resources\EquipoResource;
use App\Models\Direccion;
use App\Models\Equipo;
use Filament\Actions\Action;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\Page;

class EditEquipo extends Page
{
    protected static string $resource = EquipoResource::class;

    protected static string $view = 'filament.pages.edit-equipo';

    public ?array $data = [];

    public Equipo $record;

    public function mount(Equipo $record): void
    {
        $this->record = $record;
        $this->form->fill($record->toArray());
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Vinculación')
                    ->schema([
                        Forms\Components\Select::make('cliente_id')
                            ->label('Cliente')
                            ->relationship('cliente', 'nombre')
                            ->searchable()
                            ->preload()
                            ->required()
                            ->live()
                            ->afterStateUpdated(fn (Forms\Set $set) => $set('direccion_id', null)),
                        Forms\Components\Select::make('direccion_id')
                            ->label('Dirección')
                            ->required()
                            ->options(function (Get $get) {
                                $clienteId = $get('cliente_id');
                                if (! $clienteId) {
                                    return [];
                                }

                                return Direccion::where('cliente_id', $clienteId)
                                    ->get()
                                    ->mapWithKeys(fn ($d) => [
                                        $d->id => "{$d->calle} {$d->numero}, {$d->comuna}",
                                    ]);
                            })
                            ->live()
                            ->searchable(),
                        Forms\Components\TextInput::make('ubicacion')
                            ->label('Ubicación en la dirección')
                            ->placeholder('ej: Oficina 3, Sala reuniones')
                            ->maxLength(255),
                    ])->columns(3),

                Forms\Components\Section::make('Identificación del equipo')
                    ->schema([
                        Forms\Components\TextInput::make('marca')->label('Marca')->maxLength(100),
                        Forms\Components\TextInput::make('modelo')->label('Modelo')->maxLength(100),
                        Forms\Components\TextInput::make('numero_serie')->label('N° de serie')->maxLength(100),
                        Forms\Components\TextInput::make('pais_fabricacion')->label('País de fabricación')->maxLength(100),
                        Forms\Components\TextInput::make('fecha_fabricacion')->label('Fecha de fabricación')->placeholder('ej: 07/2013')->maxLength(20),
                        Forms\Components\Toggle::make('activo')->label('Equipo activo')->default(true),
                    ])->columns(3),

                Forms\Components\Section::make('Datos eléctricos')
                    ->schema([
                        Forms\Components\TextInput::make('tension_nominal')->label('Tensión nominal')->placeholder('ej: 220-240V~')->maxLength(50),
                        Forms\Components\TextInput::make('frecuencia')->label('Frecuencia')->placeholder('ej: 50Hz')->maxLength(20),
                        Forms\Components\TextInput::make('potencia_calefaccion')->label('Potencia calefacción (W)')->maxLength(20),
                        Forms\Components\TextInput::make('potencia_enfriamiento')->label('Potencia enfriamiento (W)')->maxLength(20),
                    ])->columns(4),

                Forms\Components\Section::make('Capacidades y refrigerante')
                    ->schema([
                        Forms\Components\TextInput::make('capacidad_calefaccion_btu')->label('Capacidad calefacción (BTU/h)')->maxLength(20),
                        Forms\Components\TextInput::make('capacidad_enfriamiento_btu')->label('Capacidad enfriamiento (BTU/h)')->maxLength(20),
                        Forms\Components\TextInput::make('tipo_refrigerante')->label('Tipo de refrigerante')->placeholder('ej: R410A')->maxLength(20),
                        Forms\Components\TextInput::make('masa_refrigerante')->label('Masa refrigerante (g)')->maxLength(20),
                        Forms\Components\TextInput::make('presion_minima')->label('Presión mínima (MPa)')->maxLength(20),
                        Forms\Components\TextInput::make('presion_maxima')->label('Presión máxima (MPa)')->maxLength(20),
                    ])->columns(3),

                Forms\Components\Section::make('Mantención')
    ->schema([
        Forms\Components\DatePicker::make('ultima_mantencion')
            ->label('Última mantención')
            ->native(false)
            ->displayFormat('d/m/Y')
            ->closeOnDateSelection()
            ->weekStartsOnMonday(),

        Forms\Components\DatePicker::make('proxima_mantencion')
            ->label('Próxima mantención (calculada automáticamente)')
            ->native(false)
            ->displayFormat('d/m/Y')
            ->disabled()        // ✅ No editable por el usuario
            ->dehydrated(false) // ✅ No se incluye en $data al guardar (el booted() lo calcula)
            ->weekStartsOnMonday(),

        Forms\Components\Textarea::make('observaciones')
            ->label('Observaciones')
            ->maxLength(500)
            ->columnSpanFull(),
    ])->columns(2),
            ])
            ->statePath('data')
            ->model($this->record);
    }

    public function save(): void
{
    $data = $this->form->getState();

    // ✅ fill()->save() SÍ dispara el booted() y recalcula proxima_mantencion
    $this->record->fill($data)->save();

    Notification::make()
        ->title('Equipo actualizado correctamente')
        ->success()
        ->send();

    $this->redirect(route('filament.admin.resources.equipos.index'));
}

    protected function getFormActions(): array
    {
        return [
            Action::make('save')
                ->label('Guardar cambios')
                ->submit('save'),
            Action::make('cancel')
                ->label('Cancelar')
                ->url(route('filament.admin.resources.equipos.index'))
                ->color('gray'),
        ];
    }
}
