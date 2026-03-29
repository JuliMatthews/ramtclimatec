<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ClienteResource\Pages;
use App\Filament\Traits\TieneUbicacion;
use App\Models\Cliente;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use App\Models\Presupuesto;
use Filament\Infolists;
use Filament\Tables\Actions\Action;
use Illuminate\Support\Facades\Storage;

class ClienteResource extends Resource
{
    use TieneUbicacion;

    protected static ?string $model = Cliente::class;
    protected static ?string $navigationIcon = 'heroicon-o-users';
    protected static ?string $navigationLabel = 'Clientes';
    protected static ?string $modelLabel = 'Cliente';
    protected static ?string $pluralModelLabel = 'Clientes';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Información personal')
                ->schema([
                    Forms\Components\TextInput::make('rut')
                        ->label('RUT')
                        ->required()
                        ->unique(ignoreRecord: true)
                        ->maxLength(12)
                        ->placeholder('12.345.678-9'),
                    Forms\Components\TextInput::make('nombre')
                        ->label('Nombre completo')
                        ->required()
                        ->maxLength(255),
                    Forms\Components\Select::make('tipo')
                        ->label('Tipo')
                        ->options([
                            'persona' => 'Persona natural',
                            'empresa' => 'Empresa',
                        ])
                        ->default('persona')
                        ->required(),
                    Forms\Components\Toggle::make('activo')
                        ->label('Cliente activo')
                        ->default(true),
                ])->columns(2),

            Forms\Components\Section::make('Ubicación')
                ->schema(self::camposUbicacion())
                ->columns(3),

            Forms\Components\Section::make('Contacto')
                ->schema([
                    Forms\Components\TextInput::make('email')
                        ->label('Correo electrónico')
                        ->email()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('telefono')
                        ->label('Teléfono')
                        ->tel()
                        ->maxLength(20)
                        ->placeholder('+56 9 1234 5678'),
                    Forms\Components\Textarea::make('observaciones')
                        ->label('Observaciones')
                        ->maxLength(500)
                        ->columnSpanFull(),
                    Forms\Components\DatePicker::make('proxima_mantencion')
                        ->label('Próxima Mantención')
                        ->nullable()
                        ->displayFormat('d/m/Y')
                        ->native(false),    
                ])->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('rut')
                    ->label('RUT')
                    ->searchable(),
                Tables\Columns\TextColumn::make('nombre')
                    ->label('Nombre')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\BadgeColumn::make('tipo')
                    ->label('Tipo')
                    ->colors([
                        'primary' => 'persona',
                        'warning' => 'empresa',
                    ]),
                Tables\Columns\TextColumn::make('region')
                    ->label('Región')
                    ->searchable(),
                Tables\Columns\TextColumn::make('comuna')
                    ->label('Comuna')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->label('Correo')
                    ->searchable(),
                Tables\Columns\TextColumn::make('telefono')
                    ->label('Teléfono'),
                Tables\Columns\IconColumn::make('activo')
                    ->label('Activo')
                    ->boolean(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Creado')
                    ->dateTime('d/m/Y')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('tipo')
                    ->label('Tipo')
                    ->options([
                        'persona' => 'Persona natural',
                        'empresa' => 'Empresa',
                    ]),
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
    public static function getRelations(): array
{
    return [
        \App\Filament\Resources\ClienteResource\RelationManagers\PresupuestosRelationManager::class,
    ];
}
    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListClientes::route('/'),
            'create' => Pages\CreateCliente::route('/create'),
            'edit'   => Pages\EditCliente::route('/{record}/edit'),
        ];
    }
}