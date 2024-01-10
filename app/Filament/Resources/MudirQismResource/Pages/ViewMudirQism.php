<?php

namespace App\Filament\Resources\MudirQismResource\Pages;

use App\Filament\Resources\MudirQismResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewMudirQism extends ViewRecord
{
    protected static string $resource = MudirQismResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
