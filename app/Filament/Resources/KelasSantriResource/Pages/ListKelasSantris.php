<?php

namespace App\Filament\Resources\KelasSantriResource\Pages;

use App\Filament\Resources\KelasSantriResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListKelasSantris extends ListRecords
{
    protected static string $resource = KelasSantriResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
