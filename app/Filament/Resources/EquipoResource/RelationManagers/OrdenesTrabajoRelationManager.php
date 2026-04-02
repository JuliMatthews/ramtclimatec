<?php

namespace App\Filament\Resources\EquipoResource\RelationManagers;

use App\Filament\Resources\OrdenTrabajoResource;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class OrdenesTrabajoRelationManager extends RelationManager
{
    protected static string $relationship = 'ordenesTrabajo';

    protected static ?string $title = 'Historial de Intervenciones';

    public function form(Form $form): Form
    {
        return $form->schema([]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('id')
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('N° OT')
                    ->sortable(),
                Tables\Columns\TextColumn::make('fecha_inicio')
                    ->label('Fecha')
                    ->date('d/m/Y')
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
                Tables\Columns\TextColumn::make('pivot.trabajo_realizado')
                    ->label('Trabajo Realizado')
                    ->wrap(),
                Tables\Columns\TextColumn::make('pivot.estado_final')
                    ->label('Estado Final')
                    ->badge()
                    ->color(fn ($state) => match ($state) {
                        'operativo' => 'success',
                        'fuera_de_servicio' => 'danger',
                        default => 'warning',
                    })
                    ->formatStateUsing(fn($state) => ucfirst(str_replace('_', ' ', $state))),
            ])
            ->filters([])
            ->headerActions([])
            ->actions([
                Tables\Actions\Action::make('ver_ot')
                    ->label('Ver OT')
                    ->icon('heroicon-o-eye')
                    ->color('info')
                    ->url(fn ($record) => OrdenTrabajoResource::getUrl('edit', ['record' => $record])),
            ])
            ->bulkActions([]);
    }
}