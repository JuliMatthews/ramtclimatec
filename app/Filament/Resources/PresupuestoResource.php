<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PresupuestoResource\Pages;
use App\Models\Presupuesto;
use App\Models\Cliente;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class PresupuestoResource extends Resource
{
    protected static ?string $model = Presupuesto::class;
    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $navigationLabel = 'Presupuestos';
    protected static ?string $modelLabel = 'Presupuesto';
    protected static ?string $pluralModelLabel = 'Presupuestos';
    protected static ?int $navigationSort = 7;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Información del Presupuesto')
                ->schema([
                    Forms\Components\Select::make('cliente_id')
                        ->label('Cliente')
                        ->options(Cliente::where('activo', true)->pluck('nombre', 'id'))
                        ->searchable()
                        ->required(),
                    Forms\Components\TextInput::make('nombre')
                        ->label('Nombre del presupuesto')
                        ->required()
                        ->maxLength(255)
                        ->placeholder('Ej: Mantención anual 2026'),
                    Forms\Components\TextInput::make('monto')
                        ->label('Monto ($)')
                        ->numeric()
                        ->prefix('$')
                        ->nullable(),
                    Forms\Components\Select::make('estado')
                        ->label('Estado')
                        ->options([
                            'pendiente'  => 'Pendiente',
                            'aprobado'   => 'Aprobado',
                            'rechazado'  => 'Rechazado',
                        ])
                        ->default('pendiente')
                        ->required(),
                    Forms\Components\Textarea::make('observaciones')
                        ->label('Observaciones')
                        ->maxLength(500)
                        ->columnSpanFull(),
                    Forms\Components\FileUpload::make('archivo')
                        ->label('Archivo PDF')
                        ->acceptedFileTypes(['application/pdf'])
                        ->directory('presupuestos')
                        ->required()
                        ->columnSpanFull(),
                ])->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('cliente.nombre')
                    ->label('Cliente')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('nombre')
                    ->label('Nombre')
                    ->searchable(),
                Tables\Columns\TextColumn::make('monto')
                    ->label('Monto')
                    ->money('CLP')
                    ->sortable(),
                Tables\Columns\BadgeColumn::make('estado')
                    ->label('Estado')
                    ->colors([
                        'warning' => 'pendiente',
                        'success' => 'aprobado',
                        'danger'  => 'rechazado',
                    ]),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Fecha')
                    ->dateTime('d/m/Y')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('estado')
                    ->label('Estado')
                    ->options([
                        'pendiente'  => 'Pendiente',
                        'aprobado'   => 'Aprobado',
                        'rechazado'  => 'Rechazado',
                    ]),
            ])
            ->actions([
                Tables\Actions\Action::make('descargar')
                    ->label('Descargar')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->color('success')
                    ->url(fn (Presupuesto $record) => asset('storage/' . $record->archivo))
                    ->openUrlInNewTab(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListPresupuestos::route('/'),
            'create' => Pages\CreatePresupuesto::route('/create'),
            'edit'   => Pages\EditPresupuesto::route('/{record}/edit'),
        ];
    }
}