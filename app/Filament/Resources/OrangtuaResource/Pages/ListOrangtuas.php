<?php

namespace App\Filament\Resources\OrangtuaResource\Pages;

use App\Filament\Resources\OrangtuaResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListOrangtuas extends ListRecords
{
    protected static string $resource = OrangtuaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
