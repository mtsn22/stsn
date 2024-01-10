<?php

namespace App\Filament\Resources;

use App\Filament\Resources\QismResource\Pages;
use App\Filament\Resources\QismResource\RelationManagers;
use App\Models\Qism;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class QismResource extends Resource
{
    protected static ?string $model = Qism::class;

    protected static ?int $navigationSort = 20;

    protected static ?string $navigationGroup = "Ma'had";

    protected static ?string $navigationLabel = 'Qism';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('qism')
                    ->maxLength(255),
                Forms\Components\TextInput::make('kode_qism')
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('qism')
                    ->searchable(),
                Tables\Columns\TextColumn::make('kode_qism')
                    ->searchable(),
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
            'index' => Pages\ListQisms::route('/'),
            'create' => Pages\CreateQism::route('/create'),
            'view' => Pages\ViewQism::route('/{record}'),
            'edit' => Pages\EditQism::route('/{record}/edit'),
        ];
    }
}
