<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MaterialResource\Pages;
use App\Models\Material;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class MaterialResource extends Resource
{
    protected static ?string $model = Material::class;

    protected static ?string $navigationIcon = 'heroicon-o-cube';

    protected static ?string $navigationLabel = 'Materiales';

    protected static ?string $modelLabel = 'Material';

    protected static ?string $pluralModelLabel = 'Materiales';

    protected static ?int $navigationSort = 5;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Información del material')
                ->schema([
                    Forms\Components\TextInput::make('nombre')
                        ->label('Nombre')
                        ->required()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('unidad')
                        ->label('Unidad de medida')
                        ->default('unidad')
                        ->required()
                        ->maxLength(50)
                        ->placeholder('unidad, metro, litro, kg...'),
                    Forms\Components\TextInput::make('precio_unitario')
                        ->label('Precio unitario')
                        ->numeric()
                        ->prefix('$')
                        ->default(0),
                    Forms\Components\Toggle::make('activo')
                        ->label('Material activo')
                        ->default(true),
                    Forms\Components\Textarea::make('descripcion')
                        ->label('Descripción')
                        ->maxLength(500)
                        ->columnSpanFull(),
                ])->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nombre')
                    ->label('Nombre')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('unidad')
                    ->label('Unidad'),
                Tables\Columns\TextColumn::make('precio_unitario')
                    ->label('Precio unitario')
                    ->money('CLP')
                    ->sortable(),
                Tables\Columns\IconColumn::make('activo')
                    ->label('Activo')
                    ->boolean(),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('activo')
                    ->label('Activo'),
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
            'index' => Pages\ListMaterials::route('/'),
            'create' => Pages\CreateMaterial::route('/create'),
            'edit' => Pages\EditMaterial::route('/{record}/edit'),
        ];
    }
}
