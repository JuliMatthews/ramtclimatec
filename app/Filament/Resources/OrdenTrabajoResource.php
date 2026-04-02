<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrdenTrabajoResource\Pages;
use App\Models\OrdenTrabajo;
use App\Models\Cliente;
use App\Models\Direccion;
use App\Models\Equipo;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class OrdenTrabajoResource extends Resource
{
    protected static ?string $model = OrdenTrabajo::class;
    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';
    protected static ?string $navigationLabel = 'Órdenes de Trabajo';
    protected static ?string $modelLabel = 'Orden de Trabajo';
    protected static ?string $pluralModelLabel = 'Órdenes de Trabajo';
    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Información general')
                ->schema([
                    Forms\Components\Select::make('cliente_id')
                        ->label('Cliente')
                        ->relationship('cliente', 'nombre')
                        ->searchable()
                        ->preload()
                        ->required()
                        ->live()
                        ->afterStateUpdated(fn($state, Forms\Set $set) => $set('direccion_id', null)),
                    Forms\Components\Select::make('direccion_id')
                        ->label('Dirección')
                        ->required()
                        ->options(function (Get $get) {
                            $clienteId = $get('cliente_id');
                            if (!$clienteId) return [];
                            return Direccion::where('cliente_id', $clienteId)
                                ->get()
                                ->mapWithKeys(fn($d) => [
                                    $d->id => "{$d->calle} {$d->numero}, {$d->comuna}"
                                ]);
                        })
                        ->live()
                        ->searchable(),
                ])->columns(2),

            Forms\Components\Section::make('Servicio')
                ->schema([
                    Forms\Components\Select::make('tipo_servicio')
                        ->label('Tipo de servicio')
                        ->options([
                            'primera_visita' => 'Primera visita (Gratis)',
                            'instalacion'    => 'Instalación',
                            'mantencion'     => 'Mantención',
                            'reparacion'     => 'Reparación',
                            'diagnostico'    => 'Diagnóstico',
                            'garantia'       => 'Garantía',
                        ])
                        ->default('primera_visita')
                        ->required(),
                    Forms\Components\TextInput::make('cantidad_equipos')
                        ->label('Cantidad de equipos')
                        ->numeric()
                        ->default(1)
                        ->minValue(1)
                        ->maxValue(99)
                        ->step(1),
                    Forms\Components\Select::make('estado')
                        ->label('Estado')
                        ->options([
                            'pendiente'   => 'Pendiente',
                            'en_progreso' => 'En progreso',
                            'completada'  => 'Completada',
                            'cancelada'   => 'Cancelada',
                        ])
                        ->default('pendiente')
                        ->required(),
                ])->columns(3),

            Forms\Components\Section::make('Fechas')
                ->schema([
                    Forms\Components\DatePicker::make('fecha_inicio')
    ->label('Fecha inicio')
    ->native(false)
    ->displayFormat('d/m/Y')
    ->closeOnDateSelection()
    ->weekStartsOnMonday(),

Forms\Components\DatePicker::make('fecha_termino')
    ->label('Fecha término')
    ->native(false)
    ->displayFormat('d/m/Y')
    ->closeOnDateSelection()
    ->weekStartsOnMonday(),
                ])->columns(2),

            Forms\Components\Section::make('Personal asignado')
                ->schema([
                    Forms\Components\Select::make('tecnicos')
                        ->label('Técnicos')
                        ->relationship('tecnicos', 'nombre')
                        ->multiple()
                        ->preload()
                        ->searchable(),
                    Forms\Components\Select::make('ayudantes')
                        ->label('Ayudantes')
                        ->relationship('ayudantes', 'nombre')
                        ->multiple()
                        ->preload()
                        ->searchable(),
                ])->columns(2),

            Forms\Components\Section::make('Equipos intervenidos')
                ->description('Selecciona los equipos trabajados en esta visita.')
                ->schema([
                    Forms\Components\Repeater::make('equipos_intervenidos')
                        ->schema([
                            Forms\Components\Select::make('equipo_id')
                                ->label('Equipo')
                                ->options(function (Get $get) {
                                    $clienteId = $get('../../cliente_id');
                                    if (!$clienteId) return [];
                                    return Equipo::where('cliente_id', $clienteId)
                                        ->get()
                                        ->mapWithKeys(fn($e) => [
                                            $e->id => "{$e->ubicacion} — {$e->marca} {$e->modelo}"
                                        ]);
                                })
                                ->searchable()
                                ->required()
                                ->columnSpan(2),
                            Forms\Components\Select::make('estado_final')
                                ->label('Estado final')
                                ->options([
                                    'operativo'        => 'Operativo',
                                    'pendiente_repuesto' => 'Pendiente repuesto',
                                    'fuera_de_servicio' => 'Fuera de servicio',
                                ])
                                ->required(),
                            Forms\Components\Textarea::make('trabajo_realizado')
                                ->label('Trabajo realizado')
                                ->rows(2)
                                ->columnSpanFull(),
                            Forms\Components\TextInput::make('presion_alta')
                                ->label('Presión alta (MPa)'),
                            Forms\Components\TextInput::make('presion_baja')
                                ->label('Presión baja (MPa)'),
                            Forms\Components\TextInput::make('temperatura_salida')
                                ->label('Temperatura salida (°C)'),
                            Forms\Components\TextInput::make('amperaje')
                                ->label('Amperaje (A)'),
                        ])
                        ->columns(3)
                        ->addActionLabel('+ Agregar equipo')
                        ->defaultItems(0)
                        ->reorderable(false),
                ]),

            Forms\Components\Section::make('Descripción y observaciones')
                ->schema([
                    Forms\Components\Textarea::make('descripcion')
                        ->label('Descripción del trabajo')
                        ->rows(3)
                        ->columnSpanFull(),
                    Forms\Components\Textarea::make('observaciones')
                        ->label('Observaciones')
                        ->rows(3)
                        ->columnSpanFull(),
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('N° OT')
                    ->sortable(),
                Tables\Columns\TextColumn::make('cliente.nombre')
                    ->label('Cliente')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('tipo_servicio')
                    ->label('Servicio')
                    ->badge()
                    ->formatStateUsing(fn($state) => match($state) {
                        'primera_visita' => 'Primera visita',
                        'instalacion'    => 'Instalación',
                        'mantencion'     => 'Mantención',
                        'reparacion'     => 'Reparación',
                        'diagnostico'    => 'Diagnóstico',
                        'garantia'       => 'Garantía',
                        default          => $state,
                    }),
                Tables\Columns\TextColumn::make('estado')
                    ->label('Estado')
                    ->badge()
                    ->color(fn($state) => match($state) {
                        'pendiente'   => 'warning',
                        'en_progreso' => 'info',
                        'completada'  => 'success',
                        'cancelada'   => 'danger',
                        default       => 'gray',
                    })
                    ->formatStateUsing(fn($state) => match($state) {
                        'pendiente'   => 'Pendiente',
                        'en_progreso' => 'En progreso',
                        'completada'  => 'Completada',
                        'cancelada'   => 'Cancelada',
                        default       => $state,
                    }),
                Tables\Columns\TextColumn::make('fecha_inicio')
                    ->label('Fecha inicio')
                    ->date('d/m/Y')
                    ->sortable(),
                Tables\Columns\TextColumn::make('fecha_termino')
                    ->label('Fecha término')
                    ->date('d/m/Y')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('estado')
                    ->label('Estado')
                    ->options([
                        'pendiente'   => 'Pendiente',
                        'en_progreso' => 'En progreso',
                        'completada'  => 'Completada',
                        'cancelada'   => 'Cancelada',
                    ]),
                Tables\Filters\SelectFilter::make('tipo_servicio')
                    ->label('Tipo de servicio')
                    ->options([
                        'primera_visita' => 'Primera visita',
                        'instalacion'    => 'Instalación',
                        'mantencion'     => 'Mantención',
                        'reparacion'     => 'Reparación',
                        'diagnostico'    => 'Diagnóstico',
                        'garantia'       => 'Garantía',
                    ]),
            ])
            ->actions([
                Tables\Actions\Action::make('pdf')
                    ->label('PDF')
                    ->icon('heroicon-o-document-arrow-down')
                    ->color('success')
                    ->url(fn(OrdenTrabajo $record) => route('ot.pdf', $record))
                    ->openUrlInNewTab(),
                Tables\Actions\Action::make('enviar_correo')
                    ->label('Enviar')
                    ->icon('heroicon-o-envelope')
                    ->color('info')
                    ->requiresConfirmation()
                    ->modalHeading('Enviar OT por correo')
                    ->modalDescription('¿Deseas enviar esta Orden de Trabajo a contacto@ramtclimatec.cl?')
                    ->modalSubmitActionLabel('Sí, enviar')
                    ->action(function (OrdenTrabajo $record) {
                        \Illuminate\Support\Facades\Mail::to('contacto@ramtclimatec.cl')
                            ->send(new \App\Mail\OrdenTrabajoMail($record));

                        \Filament\Notifications\Notification::make()
                            ->title('Correo enviado correctamente')
                            ->success()
                            ->send();
                    }),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->defaultSort('id', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListOrdenTrabajos::route('/'),
            'create' => Pages\CreateOrdenTrabajo::route('/create'),
            'edit'   => Pages\EditOrdenTrabajo::route('/{record}/edit'),
        ];
    }
}