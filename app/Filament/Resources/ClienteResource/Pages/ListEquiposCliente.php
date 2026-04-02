<?php

namespace App\Filament\Resources\EquipoResource\Pages;

use App\Filament\Resources\EquipoResource;
use App\Models\Cliente;
use App\Models\Equipo;
use Filament\Resources\Pages\Page;
use Filament\Tables;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;

class ListEquiposCliente extends Page implements HasTable
{
    use InteractsWithTable;

    protected static string $resource = EquipoResource::class;

    protected static string $view = 'filament.pages.list-equipos-cliente';

    public Cliente $record;

    public function mount(Cliente $record): void
    {
        $this->record = $record;
    }

    public function getTitle(): string
    {
        return 'Equipos de '.$this->record->nombre;
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(Equipo::query()->where('cliente_id', $this->record->id))
            ->columns([
                Tables\Columns\TextColumn::make('ubicacion')
                    ->label('Ubicación')
                    ->searchable(),
                Tables\Columns\TextColumn::make('marca')
                    ->label('Marca')
                    ->searchable(),
                Tables\Columns\TextColumn::make('modelo')
                    ->label('Modelo')
                    ->searchable(),
                Tables\Columns\TextColumn::make('capacidad_enfriamiento_btu')
                    ->label('BTU')
                    ->searchable(),
                Tables\Columns\TextColumn::make('tipo_refrigerante')
                    ->label('Refrigerante'),
                Tables\Columns\TextColumn::make('ultima_mantencion')
                    ->label('Última mantención')
                    ->date('d/m/Y')
                    ->sortable(),
                Tables\Columns\TextColumn::make('proxima_mantencion')
                    ->label('Próxima mantención')
                    ->date('d/m/Y')
                    ->sortable(),
                Tables\Columns\IconColumn::make('activo')
                    ->label('Activo')
                    ->boolean(),
            ])
            ->actions([
                Tables\Actions\Action::make('ver_ficha')
                    ->label('Ver Ficha')
                    ->icon('heroicon-o-document-text')
                    ->color('info')
                    ->url(fn (Equipo $record) => route('filament.admin.resources.equipos.view', $record)),
                Tables\Actions\Action::make('edit')
                    ->label('Editar')
                    ->icon('heroicon-o-pencil')
                    ->color('warning')
                    ->url(fn (Equipo $record) => route('filament.admin.resources.equipos.edit', $record)),
                Tables\Actions\DeleteAction::make(),
            ])
            ->headerActions([
                Tables\Actions\Action::make('crear_equipo')
                    ->label('Agregar Equipo')
                    ->icon('heroicon-o-plus')
                    ->color('primary')
                    ->url(route('filament.admin.resources.equipos.create')),
            ]);
    }
}
