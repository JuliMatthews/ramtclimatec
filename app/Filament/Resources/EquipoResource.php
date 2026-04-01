<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EquipoResource\Pages;
use App\Models\Cliente;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Form;

class EquipoResource extends Resource
{
    protected static ?string $model = Cliente::class;
    protected static ?string $navigationIcon = 'heroicon-o-cpu-chip';
    protected static ?string $navigationLabel = 'Equipos';
    protected static ?string $modelLabel = 'Cliente';
    protected static ?string $pluralModelLabel = 'Equipos';
    protected static ?int $navigationSort = 7;

    public static function form(Form $form): Form
    {
        return $form->schema([]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nombre')
                    ->label('Cliente')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\BadgeColumn::make('tipo')
                    ->label('Tipo')
                    ->colors([
                        'primary' => 'persona',
                        'warning' => 'empresa',
                    ]),
                Tables\Columns\TextColumn::make('comuna')
                    ->label('Comuna')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->label('Correo')
                    ->searchable(),
                Tables\Columns\TextColumn::make('telefono')
                    ->label('Teléfono'),
                Tables\Columns\TextColumn::make('equipos_count')
                    ->label('Equipos')
                    ->counts('equipos')
                    ->alignCenter()
                    ->sortable(),
                Tables\Columns\IconColumn::make('activo')
                    ->label('Activo')
                    ->boolean(),
            ])
            ->actions([
                Tables\Actions\Action::make('ver_equipos')
                    ->label('Ver Equipos')
                    ->icon('heroicon-o-cpu-chip')
                    ->color('info')
                    ->url(fn(Cliente $record) => route('filament.admin.resources.equipos.cliente', $record)),
            ])
            ->filters([])
            ->bulkActions([]);
    }

    public static function getPages(): array
    {
        return [
            'index'   => Pages\ListEquipos::route('/'),
            'cliente' => Pages\ListEquiposCliente::route('/{record}/equipos'),
            'view'    => Pages\ViewEquipo::route('/{record}/ficha'),
            'create'  => Pages\CreateEquipo::route('/create'),
            'edit'    => Pages\EditEquipo::route('/{record}/edit'),
        ];
    }
}