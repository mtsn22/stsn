<?php

namespace App\Filament\Walisantri\Resources\WalisantriResource\Widgets;

use App\Filament\Walisantri\Resources\WalisantriResource;
use App\Models\Walisantri;
use Egulias\EmailValidator\Parser\Comment;
use Filament\Tables;
use Filament\Tables\Actions\Action as ActionsAction;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Support\Facades\Auth;
use Filament\Tables\Actions\Action;


class DataWalisantri extends BaseWidget
{

    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->paginated(false)
            ->query(
                Walisantri::where('user_id',Auth::user()->id)
            )
            ->columns([
                Tables\Columns\TextColumn::make('ak_nama_lengkap')
                ->label('Langkah 1 -> Edit Data Walisantri'),
            ])
            ->actions([
                Action::make('Edit')
                    ->url(fn (Walisantri $record): string => WalisantriResource::getUrl('edit', ['record' => $record]))
                    ->openUrlInNewTab()
            ]);
    }
}
