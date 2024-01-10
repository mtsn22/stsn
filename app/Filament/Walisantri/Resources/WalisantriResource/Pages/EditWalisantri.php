<?php

namespace App\Filament\Walisantri\Resources\WalisantriResource\Pages;

use App\Filament\Walisantri\Resources\WalisantriResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditWalisantri extends EditRecord
{
    protected static string $resource = WalisantriResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            // Actions\DeleteAction::make(),
        ];
    }
}
