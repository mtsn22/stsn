<?php

namespace App\Filament\Pengajar\Resources\PendaftarResource\Pages;

use App\Filament\Pengajar\Resources\PendaftarResource;
use Filament\Actions;
use Filament\Pages\Concerns\ExposesTableToWidgets;
use Filament\Resources\Pages\ListRecords;

class ListPendaftars extends ListRecords
{
    use ExposesTableToWidgets;

    protected static string $resource = PendaftarResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\CreateAction::make(),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return PendaftarResource::getWidgets();
    }
}
