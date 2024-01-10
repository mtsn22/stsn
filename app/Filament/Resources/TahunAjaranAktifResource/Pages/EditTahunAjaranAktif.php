<?php

namespace App\Filament\Resources\TahunAjaranAktifResource\Pages;

use App\Filament\Resources\TahunAjaranAktifResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTahunAjaranAktif extends EditRecord
{
    protected static string $resource = TahunAjaranAktifResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
