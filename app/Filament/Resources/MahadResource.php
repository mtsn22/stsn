<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MahadResource\Pages;
use App\Filament\Resources\MahadResource\RelationManagers;
use App\Models\Mahad;
use App\Models\Kabupaten;
use App\Models\Kecamatan;
use App\Models\Kelurahan;
use App\Models\Kodepos;
use App\Models\Provinsi;
use Filament\Forms;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class MahadResource extends Resource
{
    protected static ?string $model = Mahad::class;

    protected static ?int $navigationSort = 10;

    protected static ?string $navigationGroup = "Ma'had";

    protected static ?string $navigationLabel = "Ma'had";

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make("Ma'had")
                ->schema([
                    Forms\Components\TextInput::make('mahad')
                        ->label("Nama Ma'had")
                        ->required(),
                    Forms\Components\TextInput::make('nsp')
                        ->label('Nomer Statistik Pesantren')
                        ->required(),
                    Fieldset::make('Data Alamat')
                        ->schema([
                        Forms\Components\Select::make('provinsi_id')
                            ->label('Provinsi')
                            ->options(Provinsi::all()->pluck('provinsi','id'))
                            ->live()
                            ->preload()
                            ->required(),
                        Forms\Components\Select::make('kabupaten_id')
                            ->label('Kabupaten')
                            ->required()
                            ->live()
                            ->options(fn (Get $get): Collection => Kabupaten::query()
                            ->where('provinsi_id', $get('provinsi_id'))
                            ->pluck('kabupaten', 'id')),
                        Forms\Components\Select::make('kecamatan_id')
                            ->label('Kecamatan')
                            ->required()
                            ->live()
                            ->options(fn (Get $get): Collection => Kecamatan::query()
                            ->where('kabupaten_id', $get('kabupaten_id'))
                            ->pluck('kecamatan', 'id')),
                        Select::make('kelurahan_id')
                            ->label('Kelurahan')
                            ->required()
                            ->live()
                            ->options(fn (Get $get): Collection => Kelurahan::query()
                            ->where('kecamatan_id', $get('kecamatan_id'))
                            ->pluck('kelurahan', 'id'))
                            ->afterStateUpdated(function (Get $get,?string $state, Set $set, ?string $old) {

                            if (($get('kodepos') ?? '') !== Str::slug($old)) {
                                return;
                            }

                            $kodepos = Kodepos::where('kelurahan_id', $state)->get('kodepos');

                            $state = $kodepos;

                            foreach ($state as $state){
                            $set('kodepos', Str::substr($state,12,5));
                            }
                            }),
                        Forms\Components\TextInput::make('rt')
                            ->label('RT')
                            ->required(),
                        Forms\Components\TextInput::make('rw')
                            ->label('RW')
                            ->required(),
                        Forms\Components\Textarea::make('alamat')
                            ->label('Alamat')
                            ->required()
                            ->columnSpanFull(),
                        TextInput::make('kodepos')
                            ->label('Kodepos')
                            ->disabled()
                            ->required(),
                            ])
                        ->columns(2),
                    ])->columns(2)
                ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([

                Tables\Columns\TextColumn::make('mahad')
                    ->label("Ma'had")
                    ->searchable(),
                Tables\Columns\TextColumn::make('nsp')
                    ->label('NSP')
                    ->searchable(),
                Tables\Columns\TextColumn::make('provinsi.provinsi')
                    ->label('Provinsi')
                    ->sortable(),
                Tables\Columns\TextColumn::make('kabupaten.kabupaten')
                    ->label('Kabupaten')
                    ->sortable(),
                Tables\Columns\TextColumn::make('kecamatan.kecamatan')
                    ->label('Kecamatan')
                    ->sortable(),
                Tables\Columns\TextColumn::make('kelurahan.kelurahan')
                    ->label('Kelurahan')
                    ->sortable(),
                Tables\Columns\TextColumn::make('rt')
                    ->label('RT')
                    ->searchable(),
                Tables\Columns\TextColumn::make('rw')
                    ->label('RW')
                    ->searchable(),
                Tables\Columns\TextColumn::make('kodepos')
                    ->label('Kodepos')
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
            'index' => Pages\ListMahads::route('/'),
            'create' => Pages\CreateMahad::route('/create'),
            'view' => Pages\ViewMahad::route('/{record}'),
            'edit' => Pages\EditMahad::route('/{record}/edit'),
        ];
    }
}
