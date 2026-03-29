<?php

namespace App\Filament\Resources\AyudanteResource\Pages;

use App\Filament\Resources\AyudanteResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAyudante extends EditRecord
{
    protected static string $resource = AyudanteResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
