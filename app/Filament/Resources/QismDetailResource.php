<?php

namespace App\Filament\Resources;

use App\Filament\Resources\QismDetailResource\Pages;
use App\Filament\Resources\QismDetailResource\RelationManagers;
use App\Models\QismDetail;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class QismDetailResource extends Resource
{
    protected static ?string $model = QismDetail::class;

    protected static ?int $navigationSort = 21;

    protected static ?string $navigationGroup = "Ma'had";

    protected static ?string $navigationLabel = 'Qism Detail';

    protected static ?string $navigationParentItem = 'Qism';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('qism_id')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('abbr_qism_detail')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('qism_detail')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('qism_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('abbr_qism_detail')
                    ->searchable(),
                Tables\Columns\TextColumn::make('qism_detail')
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
            'index' => Pages\ListQismDetails::route('/'),
            'create' => Pages\CreateQismDetail::route('/create'),
            'view' => Pages\ViewQismDetail::route('/{record}'),
            'edit' => Pages\EditQismDetail::route('/{record}/edit'),
        ];
    }
}
