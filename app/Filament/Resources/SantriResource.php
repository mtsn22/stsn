<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SantriResource\Pages;
use App\Filament\Resources\SantriResource\RelationManagers;
use App\Models\Santri;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SantriResource extends Resource
{
    protected static ?string $model = Santri::class;

    protected static ?int $navigationSort = 110;

    protected static ?string $navigationGroup = 'Santri';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('orangtua_id')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('provinsi_id')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('kabupaten_id')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('kecamatan_id')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('kelurahan_id')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('kodepos_id')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('nism')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('nama_lengkap')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('nama_panggilan')
                    ->maxLength(255),
                Forms\Components\TextInput::make('nisn')
                    ->maxLength(255),
                Forms\Components\Toggle::make('belum_punya_nism'),
                Forms\Components\TextInput::make('kewarganegaraan')
                    ->maxLength(255),
                Forms\Components\TextInput::make('asal_negara')
                    ->maxLength(255),
                Forms\Components\TextInput::make('kitas')
                    ->maxLength(255),
                Forms\Components\TextInput::make('nik')
                    ->maxLength(255),
                Forms\Components\Toggle::make('belum_punya_nik'),
                Forms\Components\TextInput::make('jenikelamin')
                    ->maxLength(255),
                Forms\Components\TextInput::make('tempat_lahir')
                    ->maxLength(255),
                Forms\Components\DatePicker::make('tanggal_lahir'),
                Forms\Components\TextInput::make('agama')
                    ->maxLength(255),
                Forms\Components\TextInput::make('cita_cita')
                    ->maxLength(255),
                Forms\Components\TextInput::make('cita_cita_lainnya')
                    ->maxLength(255),
                Forms\Components\TextInput::make('anak_ke')
                    ->maxLength(255),
                Forms\Components\TextInput::make('jumlah_saudara')
                    ->maxLength(255),
                Forms\Components\Toggle::make('tdk_hp'),
                Forms\Components\TextInput::make('nomor_handphone')
                    ->tel()
                    ->maxLength(255),
                Forms\Components\TextInput::make('email')
                    ->email()
                    ->maxLength(255),
                Forms\Components\TextInput::make('hobi')
                    ->maxLength(255),
                Forms\Components\TextInput::make('aktivitapend')
                    ->maxLength(255),
                Forms\Components\TextInput::make('bya_sklh')
                    ->maxLength(255),
                Forms\Components\TextInput::make('kebutuhan_khusus')
                    ->maxLength(255),
                Forms\Components\TextInput::make('keb_dis')
                    ->maxLength(255),
                Forms\Components\TextInput::make('nomor_kip')
                    ->maxLength(255),
                Forms\Components\TextInput::make('kartu_keluarga')
                    ->maxLength(255),
                Forms\Components\TextInput::make('nama_kpl_kel')
                    ->maxLength(255),
                Forms\Components\TextInput::make('file_kip')
                    ->maxLength(255),
                Forms\Components\TextInput::make('al_s_status_mukim')
                    ->maxLength(255),
                Forms\Components\TextInput::make('al_s_stts_tptgl')
                    ->maxLength(255),
                Forms\Components\TextInput::make('al_s_stts_rmh')
                    ->maxLength(255),
                Forms\Components\TextInput::make('al_s_rt')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('al_s_rw')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Textarea::make('al_s_alamat')
                    ->required()
                    ->maxLength(65535)
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('al_s_jarak')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('al_s_transportasi')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('al_s_waktu_tempuh')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('al_s_koordinat')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('orangtua_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('provinsi_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('kabupaten_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('kecamatan_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('kelurahan_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('kodepos_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('nism')
                    ->searchable(),
                Tables\Columns\TextColumn::make('nama_lengkap')
                    ->searchable(),
                Tables\Columns\TextColumn::make('nama_panggilan')
                    ->searchable(),
                Tables\Columns\TextColumn::make('nisn')
                    ->searchable(),
                Tables\Columns\IconColumn::make('belum_punya_nism')
                    ->boolean(),
                Tables\Columns\TextColumn::make('kewarganegaraan')
                    ->searchable(),
                Tables\Columns\TextColumn::make('asal_negara')
                    ->searchable(),
                Tables\Columns\TextColumn::make('kitas')
                    ->searchable(),
                Tables\Columns\TextColumn::make('nik')
                    ->searchable(),
                Tables\Columns\IconColumn::make('belum_punya_nik')
                    ->boolean(),
                Tables\Columns\TextColumn::make('jenikelamin')
                    ->searchable(),
                Tables\Columns\TextColumn::make('tempat_lahir')
                    ->searchable(),
                Tables\Columns\TextColumn::make('tanggal_lahir')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('agama')
                    ->searchable(),
                Tables\Columns\TextColumn::make('cita_cita')
                    ->searchable(),
                Tables\Columns\TextColumn::make('cita_cita_lainnya')
                    ->searchable(),
                Tables\Columns\TextColumn::make('anak_ke')
                    ->searchable(),
                Tables\Columns\TextColumn::make('jumlah_saudara')
                    ->searchable(),
                Tables\Columns\IconColumn::make('tdk_hp')
                    ->boolean(),
                Tables\Columns\TextColumn::make('nomor_handphone')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('hobi')
                    ->searchable(),
                Tables\Columns\TextColumn::make('aktivitapend')
                    ->searchable(),
                Tables\Columns\TextColumn::make('bya_sklh')
                    ->searchable(),
                Tables\Columns\TextColumn::make('kebutuhan_khusus')
                    ->searchable(),
                Tables\Columns\TextColumn::make('keb_dis')
                    ->searchable(),
                Tables\Columns\TextColumn::make('nomor_kip')
                    ->searchable(),
                Tables\Columns\TextColumn::make('kartu_keluarga')
                    ->searchable(),
                Tables\Columns\TextColumn::make('nama_kpl_kel')
                    ->searchable(),
                Tables\Columns\TextColumn::make('file_kip')
                    ->searchable(),
                Tables\Columns\TextColumn::make('al_s_status_mukim')
                    ->searchable(),
                Tables\Columns\TextColumn::make('al_s_stts_tptgl')
                    ->searchable(),
                Tables\Columns\TextColumn::make('al_s_stts_rmh')
                    ->searchable(),
                Tables\Columns\TextColumn::make('al_s_rt')
                    ->searchable(),
                Tables\Columns\TextColumn::make('al_s_rw')
                    ->searchable(),
                Tables\Columns\TextColumn::make('al_s_jarak')
                    ->searchable(),
                Tables\Columns\TextColumn::make('al_s_transportasi')
                    ->searchable(),
                Tables\Columns\TextColumn::make('al_s_waktu_tempuh')
                    ->searchable(),
                Tables\Columns\TextColumn::make('al_s_koordinat')
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
            'index' => Pages\ListSantris::route('/'),
            'create' => Pages\CreateSantri::route('/create'),
            'view' => Pages\ViewSantri::route('/{record}'),
            'edit' => Pages\EditSantri::route('/{record}/edit'),
        ];
    }
}
