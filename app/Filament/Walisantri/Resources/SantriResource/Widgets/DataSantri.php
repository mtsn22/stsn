<?php

namespace App\Filament\Walisantri\Resources\SantriResource\Widgets;

use App\Filament\Walisantri\Resources\SantriResource;
use App\Models\Santri;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Support\Facades\Auth;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\Layout\Split;
use Filament\Tables\Columns\Layout\Stack;
use Filament\Tables\Enums\ActionsPosition;

class DataSantri extends BaseWidget
{
    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->paginated(false)
            ->query(
                // Santri::where('kartu_keluarga',Auth::user()->username)
                Santri::whereHas('walisantri.user', function($query){
                    $query->where('id', Auth::user()->id);

                })
            )
            ->columns([

                Tables\Columns\TextColumn::make('nama_lengkap')
                ->label('Langkah 2 -> Edit Data Santri'),

            ])
            ->actions([
                Action::make('Edit')
                    ->url(fn (Santri $record): string => SantriResource::getUrl('edit', ['record' => $record]))
                    ->openUrlInNewTab()
            ]);
    }
}
