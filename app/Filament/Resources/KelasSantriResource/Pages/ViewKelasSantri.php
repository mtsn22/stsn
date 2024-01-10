<?php

namespace App\Filament\Resources\KelasSantriResource\Pages;

use App\Filament\Resources\KelasSantriResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewKelasSantri extends ViewRecord
{
    protected static string $resource = KelasSantriResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
