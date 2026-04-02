<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TecnicoResource\Pages;
use App\Filament\Traits\TieneUbicacion;
use App\Models\Tecnico;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class TecnicoResource extends Resource
{
    use TieneUbicacion;

    protected static ?string $model = Tecnico::class;

    protected static ?string $navigationIcon = 'heroicon-o-wrench-screwdriver';

    protected static ?string $navigationLabel = 'Técnicos';

    protected static ?string $modelLabel = 'Técnico';

    protected static ?string $pluralModelLabel = 'Técnicos';

    protected static ?int $navigationSort = 4;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Información del técnico')
                ->schema([
                    Forms\Components\TextInput::make('nombre')
                        ->label('Nombre completo')
                        ->required()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('rut')
                        ->label('RUT')
                        ->unique(ignoreRecord: true)
                        ->maxLength(12)
                        ->placeholder('12.345.678-9'),
                    Forms\Components\TextInput::make('telefono')
                        ->label('Teléfono')
                        ->tel()
                        ->maxLength(20)
                        ->placeholder('+56 9 1234 5678'),
                    Forms\Components\TextInput::make('email')
                        ->label('Correo electrónico')
                        ->email()
                        ->maxLength(255),
                    Forms\Components\Toggle::make('activo')
                        ->label('Técnico activo')
                        ->default(true),
                ])->columns(2),

            Forms\Components\Section::make('Ubicación')
                ->schema(self::camposUbicacion())
                ->columns(3),

            Forms\Components\Section::make('Observaciones')
                ->schema([
                    Forms\Components\Textarea::make('observaciones')
                        ->label('Observaciones')
                        ->maxLength(500)
                        ->columnSpanFull(),
                ]),
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
                Tables\Columns\TextColumn::make('rut')
                    ->label('RUT')
                    ->searchable(),
                Tables\Columns\TextColumn::make('telefono')
                    ->label('Teléfono'),
                Tables\Columns\TextColumn::make('email')
                    ->label('Correo'),
                Tables\Columns\TextColumn::make('comuna')
                    ->label('Comuna')
                    ->searchable(),
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
            'index' => Pages\ListTecnicos::route('/'),
            'create' => Pages\CreateTecnico::route('/create'),
            'edit' => Pages\EditTecnico::route('/{record}/edit'),
        ];
    }
}
