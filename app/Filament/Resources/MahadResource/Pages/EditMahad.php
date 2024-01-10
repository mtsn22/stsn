<?php

namespace App\Filament\Resources\MahadResource\Pages;

use App\Filament\Resources\MahadResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditMahad extends EditRecord
{
    protected static string $resource = MahadResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
