<?php

namespace App\Filament\Resources\StatusSantriResource\Pages;

use App\Filament\Resources\StatusSantriResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditStatusSantri extends EditRecord
{
    protected static string $resource = StatusSantriResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
