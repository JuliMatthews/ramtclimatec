<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProximaMantencionResource\Pages;
use App\Models\Equipo;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class ProximaMantencionResource extends Resource
{
    protected static ?string $model = Equipo::class;

    protected static ?string $navigationIcon = 'heroicon-o-clock';
    protected static ?string $navigationLabel = 'Próximas Mantenciones';
    protected static ?int $navigationSort = 4;

    public static function table(Table $table): Table
    {
        return $table
            ->query(self::getQuery())
            ->columns([
                Tables\Columns\TextColumn::make('cliente.nombre')
                    ->label('Cliente'),

                Tables\Columns\TextColumn::make('ubicacion')
                    ->label('Ubicación'),

                Tables\Columns\TextColumn::make('marca')
                    ->label('Marca'),

                Tables\Columns\TextColumn::make('modelo')
                    ->label('Modelo'),

                Tables\Columns\TextColumn::make('proxima_mantencion')
                    ->label('Próxima mantención')
                    ->date('d/m/Y'),
            ])
            ->defaultSort('proxima_mantencion', 'asc');
    }

    public static function getQuery(): Builder
    {
        return Equipo::query()
            ->whereNotNull('proxima_mantencion')
            ->whereDate('proxima_mantencion', '<=', now()->addDays(30));
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProximaMantencions::route('/'),
        ];
    }
}