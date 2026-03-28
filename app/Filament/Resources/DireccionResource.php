<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DireccionResource\Pages;
use App\Models\Direccion;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class DireccionResource extends Resource
{
    protected static ?string $model = Direccion::class;
    protected static ?string $navigationIcon = 'heroicon-o-map-pin';
    protected static ?string $navigationLabel = 'Direcciones';
    protected static ?string $modelLabel = 'Dirección';
    protected static ?string $pluralModelLabel = 'Direcciones';
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Datos de la dirección')
                ->schema([
                    Forms\Components\Select::make('cliente_id')
                        ->label('Cliente')
                        ->relationship('cliente', 'nombre')
                        ->searchable()
                        ->preload()
                        ->required(),
                    Forms\Components\Toggle::make('principal')
                        ->label('Dirección principal')
                        ->default(false),
                    Forms\Components\TextInput::make('calle')
                        ->label('Calle')
                        ->required()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('numero')
                        ->label('Número')
                        ->maxLength(20),
                    Forms\Components\TextInput::make('depto')
                        ->label('Depto / Oficina')
                        ->maxLength(50),
                    Forms\Components\TextInput::make('comuna')
                        ->label('Comuna')
                        ->required()
                        ->maxLength(100),
                    Forms\Components\TextInput::make('ciudad')
                        ->label('Ciudad')
                        ->default('Santiago')
                        ->maxLength(100),
                    Forms\Components\TextInput::make('region')
                        ->label('Región')
                        ->default('Metropolitana')
                        ->maxLength(100),
                    Forms\Components\Textarea::make('referencia')
                        ->label('Referencia')
                        ->maxLength(500)
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
                Tables\Columns\TextColumn::make('calle')
                    ->label('Calle')
                    ->searchable(),
                Tables\Columns\TextColumn::make('numero')
                    ->label('Número'),
                Tables\Columns\TextColumn::make('comuna')
                    ->label('Comuna')
                    ->searchable(),
                Tables\Columns\TextColumn::make('ciudad')
                    ->label('Ciudad'),
                Tables\Columns\IconColumn::make('principal')
                    ->label('Principal')
                    ->boolean(),
            ])
            ->filters([
                //
            ])
            ->actions([
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
            'index'  => Pages\ListDireccions::route('/'),
            'create' => Pages\CreateDireccion::route('/create'),
            'edit'   => Pages\EditDireccion::route('/{record}/edit'),
        ];
    }
}