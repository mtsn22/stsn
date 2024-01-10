<?php

namespace App\Filament\Resources\OrangtuaResource\Pages;

use App\Filament\Resources\OrangtuaResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewOrangtua extends ViewRecord
{
    protected static string $resource = OrangtuaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
