<?php

namespace App\Filament\Resources\ErrorResource\Pages;

use App\Filament\Resources\ErrorResource;
use App\Models\Error;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Pages\Page;

class ErrorSearch extends Page
{
    protected static string $resource = ErrorResource::class;

    protected static ?string $title = 'Buscar Errores';

    public ?array $data = [];

    public array $results = [];

    public function mount(): void
    {
        $this->form->fill();
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Búsqueda de Errores')
                    ->description('Ingresa marca o código de error para buscar')
                    ->schema([
                        Forms\Components\Select::make('marca')
                            ->label('Marca')
                            ->options(fn () => Error::distinct()->pluck('marca', 'marca')->toArray())
                            ->searchable()
                            ->preload()
                            ->nullable(),
                        Forms\Components\TextInput::make('codigo')
                            ->label('Código de Error')
                            ->placeholder('ej: E1, F2, etc')
                            ->nullable(),
                    ])->columns(2),
            ])
            ->statePath('data')
            ->live();
    }

    public function updated(): void
    {
        $this->search();
    }

    public function search(): void
    {
        $data = $this->form->getState();
        $query = Error::query();

        if (!empty($data['marca'])) {
            $query->where('marca', $data['marca']);
        }

        if (!empty($data['codigo'])) {
            $query->where('codigo_error', 'LIKE', '%' . $data['codigo'] . '%');
        }

        $this->results = $query->get()->toArray();
    }
}