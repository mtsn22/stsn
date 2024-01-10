<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MudirQismResource\Pages;
use App\Filament\Resources\MudirQismResource\RelationManagers;
use App\Models\MudirQism;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class MudirQismResource extends Resource
{
    protected static ?string $model = MudirQism::class;

    protected static ?int $navigationSort = 90;

    protected static ?string $navigationGroup = 'Pengajar';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('pengajar_id')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('qism_id')
                    ->required()
                    ->numeric(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('pengajar_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('qism_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMudirQisms::route('/'),
            'create' => Pages\CreateMudirQism::route('/create'),
            'view' => Pages\ViewMudirQism::route('/{record}'),
            'edit' => Pages\EditMudirQism::route('/{record}/edit'),
        ];
    }
}
