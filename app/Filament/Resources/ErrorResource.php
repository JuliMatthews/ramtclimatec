<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ErrorResource\Pages;
use App\Models\Error;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ErrorResource extends Resource
{
    protected static ?string $model = Error::class;

    protected static ?string $navigationIcon = 'heroicon-o-exclamation-circle';

    protected static ?string $navigationLabel = 'Errores';

    protected static ?string $modelLabel = 'Error';

    protected static ?string $pluralModelLabel = 'Errores';

    protected static ?int $navigationSort = 8;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('marca')
                    ->label('Marca')
                    ->required()
                    ->maxLength(100),
                Forms\Components\TextInput::make('tipo_equipo')
                    ->label('Tipo de Equipo')
                    ->required()
                    ->maxLength(100),
                Forms\Components\TextInput::make('codigo_error')
                    ->label('Código de Error')
                    ->required()
                    ->maxLength(50),
                Forms\Components\TextInput::make('descripcion')
                    ->label('Descripción')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Textarea::make('causa_probable')
                    ->label('Causa Probable')
                    ->required(),
                Forms\Components\Textarea::make('solucion')
                    ->label('Solución')
                    ->required(),
                Forms\Components\Textarea::make('notas')
                    ->label('Notas')
                    ->nullable(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('marca')
                    ->label('Marca')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('tipo_equipo')
                    ->label('Tipo')
                    ->searchable(),
                Tables\Columns\TextColumn::make('codigo_error')
                    ->label('Código')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('descripcion')
                    ->label('Descripción')
                    ->limit(50),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('marca')
                    ->label('Marca')
                    ->options(fn () => Error::distinct()->pluck('marca', 'marca')->toArray())
                    ->searchable(),
                Tables\Filters\SelectFilter::make('tipo_equipo')
                    ->label('Tipo de Equipo')
                    ->options(fn () => Error::distinct()->pluck('tipo_equipo', 'tipo_equipo')->toArray())
                    ->searchable(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('marca');
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListErrors::route('/'),
            'search' => Pages\ErrorSearch::route('/buscar'),
            'create' => Pages\CreateError::route('/create'),
            'edit' => Pages\EditError::route('/{record}/edit'),
        ];
}
}