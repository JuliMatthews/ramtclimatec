<?php

namespace App\Filament\Resources\ProximaMantencionResource\Pages;

use App\Filament\Resources\ProximaMantencionResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditProximaMantencion extends EditRecord
{
    protected static string $resource = ProximaMantencionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
