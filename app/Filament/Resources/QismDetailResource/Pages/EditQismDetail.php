<?php

namespace App\Filament\Resources\QismDetailResource\Pages;

use App\Filament\Resources\QismDetailResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditQismDetail extends EditRecord
{
    protected static string $resource = QismDetailResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
