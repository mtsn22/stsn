<?php

namespace App\Filament\Walisantri\Resources\WalisantriResource\Pages;

use App\Filament\Walisantri\Resources\WalisantriResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListWalisantris extends ListRecords
{
    protected static string $resource = WalisantriResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
