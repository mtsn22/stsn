<?php

namespace App\Filament\Pengajar\Resources\PendaftarResource\Pages;

use App\Filament\Pengajar\Resources\PendaftarResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewPendaftar extends ViewRecord
{
    protected static string $resource = PendaftarResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
