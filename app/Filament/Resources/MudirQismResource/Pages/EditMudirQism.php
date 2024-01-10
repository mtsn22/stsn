<?php

namespace App\Filament\Resources\MudirQismResource\Pages;

use App\Filament\Resources\MudirQismResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditMudirQism extends EditRecord
{
    protected static string $resource = MudirQismResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
