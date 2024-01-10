<?php

namespace App\Filament\Resources\QismResource\Pages;

use App\Filament\Resources\QismResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditQism extends EditRecord
{
    protected static string $resource = QismResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
