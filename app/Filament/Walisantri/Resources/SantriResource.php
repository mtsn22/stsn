<?php

namespace App\Filament\Walisantri\Resources;

use App\Filament\Walisantri\Resources\SantriResource\Pages;
use App\Filament\Walisantri\Resources\SantriResource\RelationManagers;
use App\Models\Santri;
use Filament\Forms;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\HtmlString;

class SantriResource extends Resource
{
    protected static ?string $model = Santri::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                Section::make('')
                    ->schema([

                        Placeholder::make('')
                            ->content(new HtmlString('<div class="sticky top-0">
                                         <p>Butuh bantuan?</p>
                                         <p>Silakan mengubungi admin di bawah ini:</p>
                                         <p><a href="https://wa.me/6282210862400">> Link Admin Putra <</a></p>
                                         <p><a href="https://wa.me/6281232171109">> Link Admin Putri <</a></p>
                                     </div>')),

                    ]),


                //SANTRI
                Section::make('')
                    ->schema([

                        Placeholder::make('')
                            ->content(new HtmlString('<div class="border-b">
                                                    <p class="text-2xl strong"><strong>SANTRI</strong></p>
                                                </div>')),


                        Forms\Components\TextInput::make('nama_lengkap')
                            ->label('Nama Lengkap')
                            ->hint('Isi sesuai dengan KK')
                            ->hintColor('danger')
                            ->required(),

                        Placeholder::make('')
                            ->content(new HtmlString('<div class="border-b">
                                                </div>')),

                        Forms\Components\TextInput::make('nism')
                            ->label('NISM')
                            ->required()
                            ->disabled(),

                        Grid::make(1)
                            ->schema([

                                Toggle::make('belum_nisn')
                                    ->label('Belum memiliki NISN')
                                    ->live(),

                                Forms\Components\TextInput::make('nisn')
                                    ->label('NISN')
                                    ->required()
                                    ->hidden(fn (Get $get) =>
                                    $get('belum_nisn') == 1),

                                    Forms\Components\Select::make('aktivitaspend')
                                    ->label('Aktivitas Pendidikan yang Diikuti')
                                    ->placeholder('Pilih Aktivitas Pendidikan yang Diikuti')
                                    ->options([
                                        'Sekolah Umum' => 'Sekolah Umum',
                                        'Madrasah' => 'Madrasah',
                                        'Perguruan Tinggi Umum' => 'Perguruan Tinggi Umum',
                                        'Perguruan Tinggi Keagamaan Islam' => 'Perguruan Tinggi Keagamaan Islam',
                                        'PKPPS' => 'PKPPS',
                                        'SPM' => 'SPM',
                                        'PDF' => 'PDF',
                                        "Ma'had Aly" => "Ma'had Aly",
                                        'Hanya Mengaji/Tidak mengikuti pendidikan formal' => 'Hanya Mengaji/Tidak mengikuti pendidikan formal',
                                    ])
                                    ->searchable()
                                    ->required()
                                    ->native(false),
                            ]),

                        Placeholder::make('')
                            ->content(new HtmlString('<div class="border-b">
                                                </div>')),

                        Forms\Components\Select::make('kewarganegaraan')
                            ->label('Kewarganegaraan')
                            ->placeholder('Pilih Kewarganegaraan')
                            ->options([
                                'WNI' => 'WNI',
                                'WNA' => 'WNA',
                            ])
                            ->required()
                            ->live()
                            ->native(false),


                        Forms\Components\TextInput::make('nik')
                            ->label('NIK')
                            ->hint('Isi sesuai dengan KK')
                            ->hintColor('danger')
                            ->length(16)
                            ->required()
                            ->hidden(fn (Get $get) =>
                            $get('kewarganegaraan') == 'WNA' ||
                                $get('kewarganegaraan') == ''),

                        Grid::make(2)
                            ->schema([

                                Forms\Components\TextInput::make('asal_negara')
                                    ->label('Asal Negara')
                                    ->required()
                                    ->hidden(fn (Get $get) =>
                                    $get('kewarganegaraan') == 'WNI' ||
                                        $get('kewarganegaraan') == ''),

                                Forms\Components\TextInput::make('kitas')
                                    ->label('KITAS')
                                    ->hint('Nomor Izin Tinggal (KITAS)')
                                    ->hintColor('danger')
                                    ->required()
                                    ->hidden(fn (Get $get) =>
                                    $get('kewarganegaraan') == 'WNI' ||
                                        $get('kewarganegaraan') == ''),
                            ]),

                        Placeholder::make('')
                            ->content(new HtmlString('<div class="border-b">
                                                </div>')),

                        Grid::make(3)
                            ->schema([

                                Forms\Components\Radio::make('jenikelamin')
                                    ->label('Jenis Kelamin')
                                    ->options([
                                        'Laki-laki' => 'Laki-laki',
                                        'Perempuan' => 'Perempuan',
                                    ])
                                    ->required()
                                    ->inline(),

                                Forms\Components\TextInput::make('tempat_lahir')
                                    ->label('Tempat Lahir')
                                    ->hint('Isi sesuai dengan KK')
                                    ->hintColor('danger')
                                    ->required(),


                                Forms\Components\DatePicker::make('tanggal_lahir')
                                    ->label('Tanggal Lahir')
                                    ->hint('Isi sesuai dengan KK')
                                    ->hintColor('danger')
                                    ->required()
                                    // ->format('dd/mm/yyyy')
                                    ->displayFormat('d M Y')
                                    ->native(false)
                                    ->closeOnDateSelection(),

                            ]),

                        Placeholder::make('')
                            ->content(new HtmlString('<div class="border-b">
                                                </div>')),

                        Grid::make(2)
                            ->schema([

                                Forms\Components\TextInput::make('jumlah_saudara')
                                    ->label('Jumlah saudara')
                                    ->required(),

                                Forms\Components\TextInput::make('anak_ke')
                                    ->label('Anak ke-')
                                    ->required()
                                    ->lte('jumlah_saudara'),




                            ]),

                        Placeholder::make('')
                            ->content(new HtmlString('<div class="border-b">
                                                </div>')),

                        Grid::make(1)
                            ->schema([

                                Forms\Components\TextInput::make('agama')
                                    ->label('Agama')
                                    ->default('Islam')
                                    ->disabled()
                                    ->required(),

                            ]),

                        Placeholder::make('')
                            ->content(new HtmlString('<div class="border-b">
                                                </div>')),

                        Grid::make(2)
                            ->schema([

                                Forms\Components\Select::make('cita_cita')
                                    ->label('Cita-cita')
                                    ->placeholder('Pilih Cita-cita')
                                    ->options([
                                        'PNS' => 'PNS',
                                        'TNI/Polri' => 'TNI/Polri',
                                        'Guru/Dosen' => 'Guru/Dosen',
                                        'Dokter' => 'Dokter',
                                        'Politikus' => 'Politikus',
                                        'Wiraswasta' => 'Wiraswasta',
                                        'Seniman/Artis' => 'Seniman/Artis',
                                        'Ilmuwan' => 'Ilmuwan',
                                        'Agamawan' => 'Agamawan',
                                        'Lainnya' => 'Lainnya',
                                    ])
                                    ->searchable()
                                    ->required()
                                    ->live()
                                    ->native(false),

                                Forms\Components\TextInput::make('cita_cita_lainnya')
                                    ->label('Cita-cita Lainnya')
                                    ->required()
                                    ->hidden(fn (Get $get) =>
                                    $get('cita_cita') !== 'Lainnya'),
                            ]),

                        Grid::make(2)
                            ->schema([
                                Forms\Components\Select::make('hobi')
                                    ->label('Hobi')
                                    ->placeholder('Pilih Hobi')
                                    ->options([
                                        'Olahraga' => 'Olahraga',
                                        'Kesetuan' => 'Kesetuan',
                                        'Membaca' => 'Membaca',
                                        'Menulis' => 'Menulis',
                                        'Jalan-jalan' => 'Jalan-jalan',
                                        'Lainnya' => 'Lainnya',
                                    ])
                                    ->searchable()
                                    ->required()
                                    ->live()
                                    ->native(false),

                                Forms\Components\TextInput::make('hobi_lainnya')
                                    ->label('Hobi Lainnya')
                                    ->required()
                                    ->hidden(fn (Get $get) =>
                                    $get('hobi') !== 'Lainnya'),

                            ]),


                            Placeholder::make('')
                            ->content(new HtmlString('<div class="border-b">
                                                </div>')),

                            Grid::make(2)
                            ->schema([
                                Forms\Components\Select::make('keb_khus')
                                    ->label('Kebutuhan Khusus')
                                    ->placeholder('Pilih Kebutuhan Khusus')
                                    ->options([
                                        'Tidak Ada' => 'Tidak Ada',
                                        'Lamban belajar' => 'Lamban belajar',
                                        'Kesulitan belajar spesifik' => 'Kesulitan belajar spesifik',
                                        'Gangguan komunikasi' => 'Gangguan komunikasi',
                                        'Berbakat/memiliki kemampuan dan kecerdasan luar biasa' => 'Berbakat/memiliki kemampuan dan kecerdasan luar biasa',
                                        'Lainnya' => 'Lainnya',
                                    ])
                                    ->searchable()
                                    ->required()
                                    ->live()
                                    ->native(false),

                                Forms\Components\TextInput::make('keb_khus_lainnya')
                                    ->label('Kebutuhan Khusus Lainnya')
                                    ->required()
                                    ->hidden(fn (Get $get) =>
                                    $get('keb_khus') !== 'Lainnya'),

                            ]),

                            Grid::make(2)
                            ->schema([
                                Forms\Components\Select::make('keb_dis')
                                    ->label('Kebutuhan Disabilitas')
                                    ->placeholder('Pilih Kebutuhan Disabilitas')
                                    ->options([
                                        'Tidak Ada' => 'Tidak Ada',
                                        'Tuna Netra' => 'Tuna Netra',
                                        'Tuna Rungu' => 'Tuna Rungu',
                                        'Tuna Daksa' => 'Tuna Daksa',
                                        'Tuna Grahita' => 'Tuna Grahita',
                                        'Tuna Laras' => 'Tuna Laras',
                                        'Tuna Wicara' => 'Tuna Wicara',
                                        'Lainnya' => 'Lainnya',
                                    ])
                                    ->searchable()
                                    ->required()
                                    ->live()
                                    ->native(false),

                                Forms\Components\TextInput::make('keb_dis_lainnya')
                                    ->label('Kebutuhan Disabilitas Lainnya')
                                    ->required()
                                    ->hidden(fn (Get $get) =>
                                    $get('keb_dis') !== 'Lainnya'),

                            ]),

                            Placeholder::make('')
                            ->content(new HtmlString('<div class="border-b">
                                                </div>')),

                            Grid::make(1)
                            ->schema([

                                Toggle::make('tdk_hp')
                                    ->label('Tidak memiliki nomer handphone')
                                    ->live(),

                                Forms\Components\TextInput::make('nomor_handphone')
                                    ->label('No. Handphone')
                                    ->helperText('Contoh: 6282187782223')
                                    ->tel()
                                    ->telRegex('/^[+]*[(]{0,1}[0-9]{1,4}[)]{0,1}[-\s\.\/0-9]*$/')
                                    ->required()
                                    ->hidden(fn (Get $get) =>
                                    $get('tdk_hp') == 1),

                                    Forms\Components\TextInput::make('email')
                                    ->label('Email')
                                    ->email(),
                            ]),

                            Placeholder::make('')
                            ->content(new HtmlString('<div class="border-b">
                                                </div>')),

                            Grid::make(1)
                            ->schema([


                            ]),

                    ]),


            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('walisantri_id')
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
                Tables\Columns\TextColumn::make('hobi_lainnya')
                    ->searchable(),
                Tables\Columns\TextColumn::make('aktivitaspend')
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
                Tables\Columns\TextColumn::make('al_s_rt')
                    ->searchable(),
                Tables\Columns\TextColumn::make('al_s_rw')
                    ->searchable(),
                Tables\Columns\TextColumn::make('kodepos')
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

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->whereHas('walisantri.user', function ($query) {
            $query->where('id', Auth::user()->id);
        });
    }
}
