<?php

namespace App\Filament\Resources\MahadResource\Pages;

use App\Filament\Resources\MahadResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewMahad extends ViewRecord
{
    protected static string $resource = MahadResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
