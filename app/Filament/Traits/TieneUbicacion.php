<?php

namespace App\Filament\Traits;

use Filament\Forms;
use Filament\Forms\Get;
use Filament\Forms\Set;

trait TieneUbicacion
{
    public static function camposUbicacion(): array
    {
        return [
            Forms\Components\Select::make('region')
                ->label('Región')
                ->options(fn() => array_combine(
                    array_keys(config('comunas')),
                    array_keys(config('comunas'))
                ))
                ->searchable()
                ->live()
                ->afterStateUpdated(function (Set $set) {
                    $set('provincia', null);
                    $set('comuna', null);
                }),

            Forms\Components\Select::make('provincia')
                ->label('Provincia')
                ->options(function (Get $get) {
                    $region = $get('region');
                    if (!$region) return [];
                    $provincias = config("comunas.{$region}", []);
                    return array_combine(
                        array_keys($provincias),
                        array_keys($provincias)
                    );
                })
                ->searchable()
                ->live()
                ->afterStateUpdated(fn(Set $set) => $set('comuna', null))
                ->disabled(fn(Get $get) => !$get('region')),

            Forms\Components\Select::make('comuna')
                ->label('Comuna')
                ->options(function (Get $get) {
                    $region   = $get('region');
                    $provincia = $get('provincia');
                    if (!$region || !$provincia) return [];
                    $comunas = config("comunas.{$region}.{$provincia}", []);
                    return array_combine($comunas, $comunas);
                })
                ->searchable()
                ->disabled(fn(Get $get) => !$get('provincia')),
        ];
    }
}