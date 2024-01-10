<?php

namespace App\Filament\Walisantri\Resources\SantriResource\Pages;

use App\Filament\Walisantri\Resources\SantriResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewSantri extends ViewRecord
{
    protected static string $resource = SantriResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
