<?php

namespace App\Filament\Resources\StatusSantriResource\Pages;

use App\Filament\Resources\StatusSantriResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewStatusSantri extends ViewRecord
{
    protected static string $resource = StatusSantriResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
