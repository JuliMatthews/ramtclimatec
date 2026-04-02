<?php

namespace App\Filament\Resources\ClienteResource\RelationManagers;

use App\Models\Presupuesto;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class PresupuestosRelationManager extends RelationManager
{
    protected static string $relationship = 'presupuestos';

    protected static ?string $title = 'Presupuestos';

    public function form(Form $form): Form
    {
        return $form->schema([
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
                    'pendiente' => 'Pendiente',
                    'aprobado' => 'Aprobado',
                    'rechazado' => 'Rechazado',
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
        ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nombre')
                    ->label('Nombre')
                    ->searchable(),
                Tables\Columns\TextColumn::make('monto')
                    ->label('Monto')
                    ->money('CLP'),
                Tables\Columns\BadgeColumn::make('estado')
                    ->label('Estado')
                    ->colors([
                        'warning' => 'pendiente',
                        'success' => 'aprobado',
                        'danger' => 'rechazado',
                    ]),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Fecha')
                    ->dateTime('d/m/Y'),
            ])
            ->actions([
                Tables\Actions\Action::make('descargar')
                    ->label('Descargar')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->color('success')
                    ->url(fn (Presupuesto $record) => asset('storage/'.$record->archivo))
                    ->openUrlInNewTab(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ]);
    }
}
