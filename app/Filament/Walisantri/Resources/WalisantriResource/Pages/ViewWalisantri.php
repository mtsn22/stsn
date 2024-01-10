<?php

namespace App\Filament\Walisantri\Resources\WalisantriResource\Pages;

use App\Filament\Walisantri\Resources\WalisantriResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewWalisantri extends ViewRecord
{
    protected static string $resource = WalisantriResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
