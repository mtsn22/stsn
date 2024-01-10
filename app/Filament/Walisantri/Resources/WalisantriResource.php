<?php

namespace App\Filament\Walisantri\Resources;

use App\Filament\Walisantri\Resources\WalisantriResource\Pages;
use App\Filament\Walisantri\Resources\WalisantriResource\RelationManagers;
use App\Models\Kabupaten;
use App\Models\Kecamatan;
use App\Models\Kelurahan;
use App\Models\Kodepos;
use App\Models\Provinsi;
use App\Models\Walisantri;
use Filament\Forms;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Str;

class WalisantriResource extends Resource
{
    protected static ?string $model = Walisantri::class;

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

                //AYAH KANDUNG
                Section::make('')
                    ->schema([

                        Placeholder::make('')
                            ->content(new HtmlString('<div class="border-b">
                                                        <p class="text-2xl strong"><strong>A. AYAH KANDUNG</strong></p>
                                                    </div>')),

                        Forms\Components\TextInput::make('ak_nama_lengkap')
                            ->label('Nama Lengkap')
                            ->hint('Isi sesuai dengan KK')
                            ->hintColor('danger')
                            ->required(),

                        Placeholder::make('')
                            ->content(new HtmlString('<div class="border-b">
                                                        <p class="text-2xl strong"><strong>A.01 STATUS AYAH KANDUNG</strong></p>
                                                    </div>')),

                        Forms\Components\Select::make('ak_status')
                            ->label('Status')
                            ->placeholder('Pilih Status')
                            ->options([
                                'Masih Hidup' => 'Masih Hidup',
                                'Sudah Meninggal' => 'Sudah Meninggal',
                                'Tidak Diketahui' => 'Tidak Diketahui',
                            ])
                            ->required()
                            ->live()
                            ->native(false),

                        Forms\Components\Select::make('ak_kewarganegaraan')
                            ->label('Kewarganegaraan')
                            ->placeholder('Pilih Kewarganegaraan')
                            ->options([
                                'WNI' => 'WNI',
                                'WNA' => 'WNA',
                            ])
                            ->required()
                            ->live()
                            ->native(false)
                            ->hidden(fn (Get $get) =>
                            $get('ak_status') == 'Sudah Meninggal' ||
                                $get('ak_status') == 'Tidak Diketahui' ||
                                $get('ak_status') == ''),

                        Forms\Components\TextInput::make('ak_nik')
                            ->label('NIK')
                            ->hint('Isi sesuai dengan KK')
                            ->hintColor('danger')
                            ->length(16)
                            ->required()
                            ->hidden(fn (Get $get) =>
                            $get('ak_kewarganegaraan') == 'WNA' ||
                                $get('ak_kewarganegaraan') == '' ||
                                $get('ak_status') == 'Sudah Meninggal' ||
                                $get('ak_status') == 'Tidak Diketahui' ||
                                $get('ak_status') == ''),

                        Grid::make(2)
                            ->schema([

                                Forms\Components\TextInput::make('ak_asal_negara')
                                    ->label('Asal Negara')
                                    ->required()
                                    ->hidden(fn (Get $get) =>
                                    $get('ak_kewarganegaraan') == 'WNI' ||
                                        $get('ak_kewarganegaraan') == '' ||
                                        $get('ak_status') == 'Sudah Meninggal' ||
                                        $get('ak_status') == 'Tidak Diketahui' ||
                                        $get('ak_status') == ''),

                                Forms\Components\TextInput::make('ak_kitas')
                                    ->label('KITAS')
                                    ->hint('Nomor Izin Tinggal (KITAS)')
                                    ->hintColor('danger')
                                    ->required()
                                    ->hidden(fn (Get $get) =>
                                    $get('ak_kewarganegaraan') == 'WNI' ||
                                        $get('ak_kewarganegaraan') == '' ||
                                        $get('ak_status') == 'Sudah Meninggal' ||
                                        $get('ak_status') == 'Tidak Diketahui' ||
                                        $get('ak_status') == ''),
                            ]),
                        Grid::make(2)
                            ->schema([

                                Forms\Components\TextInput::make('ak_tempat_lahir')
                                    ->label('Tempat Lahir')
                                    ->hint('Isi sesuai dengan KK')
                                    ->hintColor('danger')
                                    ->required()
                                    ->hidden(fn (Get $get) =>
                                    $get('ak_status') == 'Sudah Meninggal' ||
                                        $get('ak_status') == 'Tidak Diketahui' ||
                                        $get('ak_status') == ''),

                                Forms\Components\DatePicker::make('ak_tanggal_lahir')
                                    ->label('Tanggal Lahir')
                                    ->hint('Isi sesuai dengan KK')
                                    ->hintColor('danger')
                                    ->required()
                                    // ->format('dd/mm/yyyy')
                                    ->displayFormat('d M Y')
                                    ->native(false)
                                    ->closeOnDateSelection()
                                    ->hidden(fn (Get $get) =>
                                    $get('ak_status') == 'Sudah Meninggal' ||
                                        $get('ak_status') == 'Tidak Diketahui' ||
                                        $get('ak_status') == ''),
                            ]),

                        Grid::make(3)
                            ->schema([

                                Forms\Components\Select::make('ak_pend_terakhir')
                                    ->label('Pendidikan Terakhir')
                                    ->placeholder('Pilih Pendidikan Terakhir')
                                    ->options([
                                        'SD/Sederajat' => 'SD/Sederajat',
                                        'SMP/Sederajat' => 'SMP/Sederajat',
                                        'SMA/Sederajat' => 'SMA/Sederajat',
                                        'D1' => 'D1',
                                        'D2' => 'D2',
                                        'D3' => 'D3',
                                        'D4/S1' => 'D4/S1',
                                        'S2' => 'S2',
                                        'S3' => 'S3',
                                        'Tidak Bersekolah' => 'Tidak Bersekolah',
                                    ])
                                    ->searchable()
                                    ->required()
                                    ->live()
                                    ->native(false)
                                    ->hidden(fn (Get $get) =>
                                    $get('ak_status') == 'Sudah Meninggal' ||
                                        $get('ak_status') == 'Tidak Diketahui' ||
                                        $get('ak_status') == ''),

                                Forms\Components\Select::make('ak_pekerjaan_utama')
                                    ->label('Pekerjaan Utama')
                                    ->placeholder('Pilih Pekerjaan Utama')
                                    ->options([
                                        'Tidak Bekerja' => 'Tidak Bekerja',
                                        'Pensiunan' => 'Pensiunan',
                                        'PNS' => 'PNS',
                                        'TNI/Polisi' => 'TNI/Polisi',
                                        'Guru/Dosen' => 'Guru/Dosen',
                                        'Pegawai Swasta' => 'Pegawai Swasta',
                                        'Wiraswasta' => 'Wiraswasta',
                                        'Pengacara/Jaksa/Hakim/Notaris' => 'Pengacara/Jaksa/Hakim/Notaris',
                                        'Seniman/Pelukis/Artis/Sejenis' => 'Seniman/Pelukis/Artis/Sejenis',
                                        'Dokter/Bidan/Perawat' => 'Dokter/Bidan/Perawat',
                                        'Pilot/Pramugara' => 'Pilot/Pramugara',
                                        'Pedagang' => 'Pedagang',
                                        'Petani/Peternak' => 'Petani/Peternak',
                                        'Nelayan' => 'Nelayan',
                                        'Buruh (Tani/Pabrik/Bangunan)' => 'Buruh (Tani/Pabrik/Bangunan)',
                                        'Sopir/Masinis/Kondektur' => 'Sopir/Masinis/Kondektur',
                                        'Politikus' => 'Politikus',
                                        'Lainnya' => 'Lainnya',
                                    ])
                                    ->searchable()
                                    ->required()
                                    ->live()
                                    ->native(false)
                                    ->hidden(fn (Get $get) =>
                                    $get('ak_status') == 'Sudah Meninggal' ||
                                        $get('ak_status') == 'Tidak Diketahui' ||
                                        $get('ak_status') == ''),

                                Forms\Components\Select::make('ak_pghsln_rt')
                                    ->label('Penghasilan Rata-Rata')
                                    ->placeholder('Pilih Penghasilan Rata-Rata')
                                    ->options([
                                        'Kurang dari 500.000' => 'Kurang dari 500.000',
                                        '500.000 - 1.000.000' => '500.000 - 1.000.000',
                                        '1.000.001 - 2.000.000' => '1.000.001 - 2.000.000',
                                        '2.000.001 - 3.000.000' => '2.000.001 - 3.000.000',
                                        '3.000.001 - 5.000.000' => '3.000.001 - 5.000.000',
                                        'Lebih dari 5.000.000' => 'Lebih dari 5.000.000',
                                        'Tidak ada' => 'Tidak ada',
                                    ])
                                    ->searchable()
                                    ->required()
                                    ->live()
                                    ->native(false)
                                    ->hidden(fn (Get $get) =>
                                    $get('ak_status') == 'Sudah Meninggal' ||
                                        $get('ak_status') == 'Tidak Diketahui' ||
                                        $get('ak_status') == ''),
                            ]),

                        Grid::make(1)
                            ->schema([

                                Toggle::make('ak_tdk_hp')
                                    ->label('Tidak memiliki nomer handphone')
                                    ->live()
                                    ->hidden(fn (Get $get) =>
                                    $get('ak_status') == 'Sudah Meninggal' ||
                                        $get('ak_status') == 'Tidak Diketahui' ||
                                        $get('ak_status') == ''),

                                Forms\Components\TextInput::make('ak_nomor_handphone')
                                    ->label('No. Handphone')
                                    ->helperText('Contoh: 6282187782223')
                                    ->tel()
                                    ->telRegex('/^[+]*[(]{0,1}[0-9]{1,4}[)]{0,1}[-\s\.\/0-9]*$/')
                                    ->required()
                                    ->hidden(fn (Get $get) =>
                                    $get('ak_tdk_hp') == 1 ||
                                        $get('ak_status') == 'Sudah Meninggal' ||
                                        $get('ak_status') == 'Tidak Diketahui' ||
                                        $get('ak_status') == ''),
                            ]),

                        // KARTU KELUARGA AYAH KANDUNG
                        Placeholder::make('')
                            ->content(new HtmlString('<div class="border-b">
                            <p class="text-2xl strong"><strong>A.02 KARTU KELUARGA</strong></p>
                            <p class="text-2xl strong"><strong>AYAH KANDUNG</strong></p>
                        </div>'))
                            ->hidden(fn (Get $get) =>
                            $get('ak_status') == 'Sudah Meninggal' ||
                                $get('ak_status') == 'Tidak Diketahui' ||
                                $get('ak_status') == ''),

                        Grid::make(2)
                            ->schema([

                                Forms\Components\TextInput::make('ak_no_kk')
                                    ->label('No. KK Ayah Kandung')
                                    ->hint('Isi sesuai dengan KK')
                                    ->hintColor('danger')
                                    ->length(16)
                                    ->required()
                                    ->hidden(fn (Get $get) =>
                                    $get('ak_status') == 'Sudah Meninggal' ||
                                        $get('ak_status') == 'Tidak Diketahui' ||
                                        $get('ak_status') == ''),

                                Forms\Components\TextInput::make('ak_kep_kel_kk')
                                    ->label('Nama Kepala Keluarga')
                                    ->hint('Isi sesuai dengan KK')
                                    ->hintColor('danger')
                                    ->required()
                                    ->hidden(fn (Get $get) =>
                                    $get('ak_status') == 'Sudah Meninggal' ||
                                        $get('ak_status') == 'Tidak Diketahui' ||
                                        $get('ak_status') == ''),
                            ]),

                        Forms\Components\FileUpload::make('ak_file_kk')
                            ->label('Upload KK')
                            ->hint('File PDF')
                            ->hintColor('danger')
                            ->helperText('Maks. 2 Mb')
                            ->directory('orangtua/ayahkandung/kk')
                            ->preserveFilenames()
                            ->acceptedFileTypes(['application/pdf'])
                            ->maxSize(2000)
                            ->required()
                            ->hidden(fn (Get $get) =>
                            $get('ak_status') == 'Sudah Meninggal' ||
                                $get('ak_status') == 'Tidak Diketahui' ||
                                $get('ak_status') == ''),

                        // ALAMAT AYAH KANDUNG
                        Placeholder::make('')
                            ->content(new HtmlString('<div class="border-b">
                                                        <p class="text-2xl strong"><strong>A.03 TEMPAT TINGGAL DOMISILI</strong></p>
                                                        <p class="text-2xl strong"><strong>AYAH KANDUNG</strong></p>
                                                    </div>'))
                            ->hidden(fn (Get $get) =>
                            $get('ak_status') == 'Sudah Meninggal' ||
                                $get('ak_status') == 'Tidak Diketahui' ||
                                $get('ak_status') == ''),

                        Toggle::make('al_ak_tgldi_ln')
                            ->label('Tinggal di luar negeri')
                            ->live()
                            ->hidden(fn (Get $get) =>
                            $get('ak_status') == 'Sudah Meninggal' ||
                                $get('ak_status') == 'Tidak Diketahui' ||
                                $get('ak_status') == ''),

                        Forms\Components\Textarea::make('al_ak_almt_ln')
                            ->label('Alamat Luar Negeri')
                            ->required()
                            ->hidden(fn (Get $get) =>
                            $get('al_ak_tgldi_ln') == 0),

                        Forms\Components\Select::make('al_ak_stts_rmh')
                            ->label('Status Kepemilikan Rumah')
                            ->placeholder('Pilih Status Kepemilikan Rumah')
                            ->options([
                                'Milik Sendiri' => 'Milik Sendiri',
                                'Rumah Orang Tua' => 'Rumah Orang Tua',
                                'Rumah Saudara/kerabat' => 'Rumah Saudara/kerabat',
                                'Rumah Dinas' => 'Rumah Dinas',
                                'Sewa/kontrak' => 'Sewa/kontrak',
                                'Lainnya' => 'Lainnya',
                            ])
                            ->searchable()
                            ->required()
                            ->live()
                            ->native(false)
                            ->hidden(fn (Get $get) =>
                            $get('al_ak_tgldi_ln') == 1 ||
                                $get('ak_status') == 'Sudah Meninggal' ||
                                $get('ak_status') == 'Tidak Diketahui' ||
                                $get('ak_status') == ''),

                        Grid::make(2)
                            ->schema([

                                Forms\Components\Select::make('al_ak_provinsi_id')
                                    ->label('Provinsi')
                                    ->placeholder('Pilih Provinsi')
                                    ->options(Provinsi::all()->pluck('provinsi', 'id'))
                                    ->searchable()
                                    ->required()
                                    ->live()
                                    ->native(false)
                                    ->hidden(fn (Get $get) =>
                                    $get('al_ak_tgldi_ln') == 1 ||
                                        $get('ak_status') == 'Sudah Meninggal' ||
                                        $get('ak_status') == 'Tidak Diketahui' ||
                                        $get('ak_status') == '')
                                    ->afterStateUpdated(function (Set $set) {
                                        $set('al_ak_kabupaten_id', null);
                                        $set('al_ak_kecamatan_id', null);
                                        $set('al_ak_kelurahan_id', null);
                                        $set('al_ak_kodepos', null);
                                    }),

                                Forms\Components\Select::make('al_ak_kabupaten_id')
                                    ->label('Kabupaten')
                                    ->placeholder('Pilih Kabupaten')
                                    ->options(fn (Get $get): Collection => Kabupaten::query()
                                        ->where('provinsi_id', $get('al_ak_provinsi_id'))
                                        ->pluck('kabupaten', 'id'))
                                    ->searchable()
                                    ->required()
                                    ->live()
                                    ->native(false)
                                    ->hidden(fn (Get $get) =>
                                    $get('al_ak_tgldi_ln') == 1 ||
                                        $get('ak_status') == 'Sudah Meninggal' ||
                                        $get('ak_status') == 'Tidak Diketahui' ||
                                        $get('ak_status') == ''),

                                Forms\Components\Select::make('al_ak_kecamatan_id')
                                    ->label('Kecamatan')
                                    ->placeholder('Pilih Kecamatan')
                                    ->options(fn (Get $get): Collection => Kecamatan::query()
                                        ->where('kabupaten_id', $get('al_ak_kabupaten_id'))
                                        ->pluck('kecamatan', 'id'))
                                    ->searchable()
                                    ->required()
                                    ->live()
                                    ->native(false)
                                    ->hidden(fn (Get $get) =>
                                    $get('al_ak_tgldi_ln') == 1 ||
                                        $get('ak_status') == 'Sudah Meninggal' ||
                                        $get('ak_status') == 'Tidak Diketahui' ||
                                        $get('ak_status') == ''),

                                Forms\Components\Select::make('al_ak_kelurahan_id')
                                    ->label('Kelurahan')
                                    ->placeholder('Pilih Kelurahan')
                                    ->options(fn (Get $get): Collection => Kelurahan::query()
                                        ->where('kecamatan_id', $get('al_ak_kecamatan_id'))
                                        ->pluck('kelurahan', 'id'))
                                    ->searchable()
                                    ->required()
                                    ->live()
                                    ->native(false)
                                    ->hidden(fn (Get $get) =>
                                    $get('al_ak_tgldi_ln') == 1 ||
                                        $get('ak_status') == 'Sudah Meninggal' ||
                                        $get('ak_status') == 'Tidak Diketahui' ||
                                        $get('ak_status') == '')
                                    ->afterStateUpdated(function (Get $get, ?string $state, Set $set, ?string $old) {

                                        if (($get('al_ak_kodepos') ?? '') !== Str::slug($old)) {
                                            return;
                                        }

                                        $kodepos = Kodepos::where('kelurahan_id', $state)->get('kodepos');

                                        $state = $kodepos;

                                        foreach ($state as $state) {
                                            $set('al_ak_kodepos', Str::substr($state, 12, 5));
                                        }
                                    }),


                                Forms\Components\TextInput::make('al_ak_rt')
                                    ->label('RT')
                                    ->required()
                                    ->hidden(fn (Get $get) =>
                                    $get('al_ak_tgldi_ln') == 1 ||
                                        $get('ak_status') == 'Sudah Meninggal' ||
                                        $get('ak_status') == 'Tidak Diketahui' ||
                                        $get('ak_status') == ''),

                                Forms\Components\TextInput::make('al_ak_rw')
                                    ->label('RW')
                                    ->required()
                                    ->hidden(fn (Get $get) =>
                                    $get('al_ak_tgldi_ln') == 1 ||
                                        $get('ak_status') == 'Sudah Meninggal' ||
                                        $get('ak_status') == 'Tidak Diketahui' ||
                                        $get('ak_status') == ''),

                                Forms\Components\Textarea::make('al_ak_alamat')
                                    ->label('Alamat')
                                    ->required()
                                    ->columnSpanFull()
                                    ->hidden(fn (Get $get) =>
                                    $get('al_ak_tgldi_ln') == 1 ||
                                        $get('ak_status') == 'Sudah Meninggal' ||
                                        $get('ak_status') == 'Tidak Diketahui' ||
                                        $get('ak_status') == ''),

                                Forms\Components\TextInput::make('al_ak_kodepos')
                                    ->label('Kodepos')
                                    ->disabled()
                                    ->required()
                                    ->hidden(fn (Get $get) =>
                                    $get('al_ak_tgldi_ln') == 1 ||
                                        $get('ak_status') == 'Sudah Meninggal' ||
                                        $get('ak_status') == 'Tidak Diketahui' ||
                                        $get('ak_status') == ''),
                            ]),
                    ]),







                //IBU KANDUNG
                Section::make('')
                    ->schema([

                        Placeholder::make('')
                            ->content(new HtmlString('<div class="border-b">
                                                        <p class="text-2xl strong"><strong>B. IBU KANDUNG</strong></p>
                                                    </div>')),

                        Forms\Components\TextInput::make('ik_nama_lengkap')
                            ->label('Nama Lengkap')
                            ->hint('Isi sesuai dengan KK')
                            ->hintColor('danger')
                            ->required(),

                        Placeholder::make('')
                            ->content(new HtmlString('<div class="border-b">
                                                        <p class="text-2xl strong"><strong>B.01 STATUS IBU KANDUNG</strong></p>
                                                    </div>')),

                        Forms\Components\Select::make('ik_status')
                            ->label('Status')
                            ->placeholder('Pilih Status')
                            ->options([
                                'Masih Hidup' => 'Masih Hidup',
                                'Sudah Meninggal' => 'Sudah Meninggal',
                                'Tidak Diketahui' => 'Tidak Diketahui',
                            ])
                            ->required()
                            ->live()
                            ->native(false),

                        Forms\Components\Select::make('ik_kewarganegaraan')
                            ->label('Kewarganegaraan')
                            ->placeholder('Pilih Kewarganegaraan')
                            ->options([
                                'WNI' => 'WNI',
                                'WNA' => 'WNA',
                            ])
                            ->required()
                            ->live()
                            ->native(false)
                            ->hidden(fn (Get $get) =>
                            $get('ik_status') == 'Sudah Meninggal' ||
                                $get('ik_status') == 'Tidak Diketahui' ||
                                $get('ik_status') == ''),

                        Forms\Components\TextInput::make('ik_nik')
                            ->label('NIK')
                            ->hint('Isi sesuai dengan KK')
                            ->hintColor('danger')
                            ->length(16)
                            ->required()
                            ->hidden(fn (Get $get) =>
                            $get('ik_kewarganegaraan') == 'WNA' ||
                                $get('ik_kewarganegaraan') == '' ||
                                $get('ik_status') == 'Sudah Meninggal' ||
                                $get('ik_status') == 'Tidak Diketahui' ||
                                $get('ik_status') == ''),

                        Grid::make(2)
                            ->schema([

                                Forms\Components\TextInput::make('ik_asal_negara')
                                    ->label('Asal Negara')
                                    ->required()
                                    ->hidden(fn (Get $get) =>
                                    $get('ik_kewarganegaraan') == 'WNI' ||
                                        $get('ik_kewarganegaraan') == '' ||
                                        $get('ik_status') == 'Sudah Meninggal' ||
                                        $get('ik_status') == 'Tidak Diketahui' ||
                                        $get('ik_status') == ''),

                                Forms\Components\TextInput::make('ik_kitas')
                                    ->label('KITAS')
                                    ->hint('Nomor Izin Tinggal (KITAS)')
                                    ->hintColor('danger')
                                    ->required()
                                    ->hidden(fn (Get $get) =>
                                    $get('ik_kewarganegaraan') == 'WNI' ||
                                        $get('ik_kewarganegaraan') == '' ||
                                        $get('ik_status') == 'Sudah Meninggal' ||
                                        $get('ik_status') == 'Tidak Diketahui' ||
                                        $get('ik_status') == ''),
                            ]),

                        Grid::make(2)
                            ->schema([

                                Forms\Components\TextInput::make('ik_tempat_lahir')
                                    ->label('Tempat Lahir')
                                    ->hint('Isi sesuai dengan KK')
                                    ->hintColor('danger')
                                    ->required()
                                    ->hidden(fn (Get $get) =>
                                    $get('ik_status') == 'Sudah Meninggal' ||
                                        $get('ik_status') == 'Tidak Diketahui' ||
                                        $get('ik_status') == ''),

                                Forms\Components\DatePicker::make('ik_tanggal_lahir')
                                    ->label('Tanggal Lahir')
                                    ->hint('Isi sesuai dengan KK')
                                    ->hintColor('danger')
                                    ->required()
                                    // ->format('dd/mm/yyyy')
                                    ->displayFormat('d M Y')
                                    ->native(false)
                                    ->closeOnDateSelection()
                                    ->hidden(fn (Get $get) =>
                                    $get('ik_status') == 'Sudah Meninggal' ||
                                        $get('ik_status') == 'Tidak Diketahui' ||
                                        $get('ik_status') == ''),
                            ]),

                        Grid::make(3)
                            ->schema([

                                Forms\Components\Select::make('ik_pend_terakhir')
                                    ->label('Pendidikan Terakhir')
                                    ->placeholder('Pilih Pendidikan Terakhir')
                                    ->options([
                                        'SD/Sederajat' => 'SD/Sederajat',
                                        'SMP/Sederajat' => 'SMP/Sederajat',
                                        'SMA/Sederajat' => 'SMA/Sederajat',
                                        'D1' => 'D1',
                                        'D2' => 'D2',
                                        'D3' => 'D3',
                                        'D4/S1' => 'D4/S1',
                                        'S2' => 'S2',
                                        'S3' => 'S3',
                                        'Tidak Bersekolah' => 'Tidak Bersekolah',
                                    ])
                                    ->searchable()
                                    ->required()
                                    ->live()
                                    ->native(false)
                                    ->hidden(fn (Get $get) =>
                                    $get('ik_status') == 'Sudah Meninggal' ||
                                        $get('ik_status') == 'Tidak Diketahui' ||
                                        $get('ik_status') == ''),

                                Forms\Components\Select::make('ik_pekerjaan_utama')
                                    ->label('Pekerjaan Utama')
                                    ->placeholder('Pilih Pekerjaan Utama')
                                    ->options([
                                        'Tidak Bekerja' => 'Tidak Bekerja',
                                        'Pensiunan' => 'Pensiunan',
                                        'PNS' => 'PNS',
                                        'TNI/Polisi' => 'TNI/Polisi',
                                        'Guru/Dosen' => 'Guru/Dosen',
                                        'Pegawai Swasta' => 'Pegawai Swasta',
                                        'Wiraswasta' => 'Wiraswasta',
                                        'Pengacara/Jaksa/Hakim/Notaris' => 'Pengacara/Jaksa/Hakim/Notaris',
                                        'Seniman/Pelukis/Artis/Sejenis' => 'Seniman/Pelukis/Artis/Sejenis',
                                        'Dokter/Bidan/Perawat' => 'Dokter/Bidan/Perawat',
                                        'Pilot/Pramugara' => 'Pilot/Pramugara',
                                        'Pedagang' => 'Pedagang',
                                        'Petani/Peternak' => 'Petani/Peternak',
                                        'Nelayan' => 'Nelayan',
                                        'Buruh (Tani/Pabrik/Bangunan)' => 'Buruh (Tani/Pabrik/Bangunan)',
                                        'Sopir/Masinis/Kondektur' => 'Sopir/Masinis/Kondektur',
                                        'Politikus' => 'Politikus',
                                        'Lainnya' => 'Lainnya',
                                    ])
                                    ->searchable()
                                    ->required()
                                    ->live()
                                    ->native(false)
                                    ->hidden(fn (Get $get) =>
                                    $get('ik_status') == 'Sudah Meninggal' ||
                                        $get('ik_status') == 'Tidak Diketahui' ||
                                        $get('ik_status') == ''),

                                Forms\Components\Select::make('ik_pghsln_rt')
                                    ->label('Penghasilan Rata-Rata')
                                    ->placeholder('Pilih Penghasilan Rata-Rata')
                                    ->options([
                                        'Kurang dari 500.000' => 'Kurang dari 500.000',
                                        '500.000 - 1.000.000' => '500.000 - 1.000.000',
                                        '1.000.001 - 2.000.000' => '1.000.001 - 2.000.000',
                                        '2.000.001 - 3.000.000' => '2.000.001 - 3.000.000',
                                        '3.000.001 - 5.000.000' => '3.000.001 - 5.000.000',
                                        'Lebih dari 5.000.000' => 'Lebih dari 5.000.000',
                                        'Tidak ada' => 'Tidak ada',
                                    ])
                                    ->searchable()
                                    ->required()
                                    ->live()
                                    ->native(false)
                                    ->hidden(fn (Get $get) =>
                                    $get('ik_status') == 'Sudah Meninggal' ||
                                        $get('ik_status') == 'Tidak Diketahui' ||
                                        $get('ik_status') == ''),
                            ]),

                        Grid::make(1)
                            ->schema([

                                Toggle::make('ik_tdk_hp')
                                    ->label('Tidak memiliki nomer handphone')
                                    ->live()
                                    ->hidden(fn (Get $get) =>
                                    $get('ik_status') == 'Sudah Meninggal' ||
                                        $get('ik_status') == 'Tidak Diketahui' ||
                                        $get('ik_status') == ''),

                                Forms\Components\TextInput::make('ik_nomor_handphone')
                                    ->label('No. Handphone')
                                    ->helperText('Contoh: 6282187782223')
                                    ->tel()
                                    ->telRegex('/^[+]*[(]{0,1}[0-9]{1,4}[)]{0,1}[-\s\.\/0-9]*$/')
                                    ->required()
                                    ->hidden(fn (Get $get) =>
                                    $get('ik_tdk_hp') == 1 ||
                                        $get('ik_status') == 'Sudah Meninggal' ||
                                        $get('ik_status') == 'Tidak Diketahui' ||
                                        $get('ik_status') == ''),
                            ]),

                        // KARTU KELUARGA IBU KANDUNG
                        Placeholder::make('')
                            ->content(new HtmlString('<div class="border-b">
                             <p class="text-2xl strong"><strong>B.02 KARTU KELUARGA</strong></p>
                             <p class="text-2xl strong"><strong>IBU KANDUNG</strong></p>
                         </div>'))
                            ->hidden(fn (Get $get) =>
                            $get('ik_status') == 'Sudah Meninggal' ||
                                $get('ik_status') == 'Tidak Diketahui' ||
                                $get('ik_status') == ''),

                        Toggle::make('ik_kk_sama_ak')
                            ->label('KK sama Dengan Ayah Kandung')
                            ->live()
                            ->afterStateUpdated(function (Get $get, Set $set) {
                                $sama = $get('ik_kk_sama_ak');
                                $set('al_ik_sama_ak', $sama);
                            })
                            ->hidden(fn (Get $get) =>
                            $get('ik_status') == 'Sudah Meninggal' ||
                                $get('ik_status') == 'Tidak Diketahui' ||
                                $get('ik_status') == ''),

                        Toggle::make('al_ik_sama_ak')
                            ->label('Alamat sama dengan Ayah Kandung')
                            ->disabled()
                            ->live()
                            ->hidden(fn (Get $get) =>
                            $get('ik_status') == 'Sudah Meninggal' ||
                                $get('ik_status') == 'Tidak Diketahui' ||
                                $get('ik_status') == ''),

                        Grid::make(2)
                            ->schema([

                                Forms\Components\TextInput::make('ik_no_kk')
                                    ->label('No. KK Ibu Kandung')
                                    ->hint('Isi sesuai dengan KK')
                                    ->hintColor('danger')
                                    ->length(16)
                                    ->required()
                                    ->hidden(fn (Get $get) =>
                                    $get('ik_kk_sama_ak') == 1 ||
                                        $get('ik_status') == 'Sudah Meninggal' ||
                                        $get('ik_status') == 'Tidak Diketahui' ||
                                        $get('ik_status') == ''),

                                Forms\Components\TextInput::make('ik_kep_kel_kk')
                                    ->label('Nama Kepala Keluarga')
                                    ->hint('Isi sesuai dengan KK')
                                    ->hintColor('danger')
                                    ->required()
                                    ->hidden(fn (Get $get) =>
                                    $get('ik_kk_sama_ak') == 1 ||
                                        $get('ik_status') == 'Sudah Meninggal' ||
                                        $get('ik_status') == 'Tidak Diketahui' ||
                                        $get('ik_status') == ''),
                            ]),

                        Forms\Components\FileUpload::make('ik_file_kk')
                            ->label('Upload KK')
                            ->hint('File PDF')
                            ->hintColor('danger')
                            ->helperText('Maks. 2 Mb')
                            ->directory('walisantri/ibukandung/kk')
                            ->preserveFilenames()
                            ->acceptedFileTypes(['application/pdf'])
                            ->maxSize(2000)
                            ->required()
                            ->hidden(fn (Get $get) =>
                            $get('ik_kk_sama_ak') == 1 ||
                                $get('ik_status') == 'Sudah Meninggal' ||
                                $get('ik_status') == 'Tidak Diketahui' ||
                                $get('ik_status') == ''),

                        // ALAMAT IBU KANDUNG
                        Placeholder::make('')
                            ->content(new HtmlString('<div class="border-b">
                                                        <p class="text-2xl strong"><strong>B.03 TEMPAT TINGGAL DOMISILI</strong></p>
                                                        <p class="text-2xl strong"><strong>IBU KANDUNG</strong></p>
                                                    </div>'))
                            ->hidden(fn (Get $get) =>
                            $get('ik_kk_sama_ak') == 1 ||
                                $get('ik_status') == 'Sudah Meninggal' ||
                                $get('ik_status') == 'Tidak Diketahui' ||
                                $get('ik_status') == ''),

                        Toggle::make('al_ik_tgldi_ln')
                            ->label('Tinggal di luar negeri')
                            ->live()
                            ->hidden(fn (Get $get) =>
                            $get('ik_kk_sama_ak') == 1 ||
                                $get('ik_status') == 'Sudah Meninggal' ||
                                $get('ik_status') == 'Tidak Diketahui' ||
                                $get('ik_status') == ''),

                        Forms\Components\Textarea::make('al_ik_almt_ln')
                            ->label('Alamat Luar Negeri')
                            ->required()
                            ->hidden(fn (Get $get) =>
                            $get('al_ik_tgldi_ln') == 0 ||
                                $get('ik_kk_sama_ak') == 1 ||
                                $get('ik_status') == 'Sudah Meninggal' ||
                                $get('ik_status') == 'Tidak Diketahui' ||
                                $get('ik_status') == ''),

                        Forms\Components\Select::make('al_ik_stts_rmh')
                            ->label('Status Kepemilikan Rumah')
                            ->placeholder('Pilih Status Kepemilikan Rumah')
                            ->options([
                                'Milik Sendiri' => 'Milik Sendiri',
                                'Rumah Orang Tua' => 'Rumah Orang Tua',
                                'Rumah Saudara/kerabat' => 'Rumah Saudara/kerabat',
                                'Rumah Dinas' => 'Rumah Dinas',
                                'Sewa/kontrak' => 'Sewa/kontrak',
                                'Lainnya' => 'Lainnya',
                            ])
                            ->searchable()
                            ->required()
                            ->live()
                            ->native(false)
                            ->hidden(fn (Get $get) =>
                            $get('al_ik_tgldi_ln') == 1 ||
                                $get('ik_kk_sama_ak') == 1 ||
                                $get('ik_status') == 'Sudah Meninggal' ||
                                $get('ik_status') == 'Tidak Diketahui' ||
                                $get('ik_status') == ''),

                        Grid::make(2)
                            ->schema([

                                Forms\Components\Select::make('al_ik_provinsi_id')
                                    ->label('Provinsi')
                                    ->placeholder('Pilih Provinsi')
                                    ->options(Provinsi::all()->pluck('provinsi', 'id'))
                                    ->searchable()
                                    ->required()
                                    ->live()
                                    ->native(false)
                                    ->hidden(fn (Get $get) =>
                                    $get('al_ik_tgldi_ln') == 1 ||
                                        $get('ik_kk_sama_ak') == 1 ||
                                        $get('ik_status') == 'Sudah Meninggal' ||
                                        $get('ik_status') == 'Tidak Diketahui' ||
                                        $get('ik_status') == '')
                                    ->afterStateUpdated(function (Set $set) {
                                        $set('al_ik_kabupaten_id', null);
                                        $set('al_ik_kecamatan_id', null);
                                        $set('al_ik_kelurahan_id', null);
                                        $set('al_ik_kodepos', null);
                                    }),

                                Forms\Components\Select::make('al_ik_kabupaten_id')
                                    ->label('Kabupaten')
                                    ->placeholder('Pilih Kabupaten')
                                    ->options(fn (Get $get): Collection => Kabupaten::query()
                                        ->where('provinsi_id', $get('al_ik_provinsi_id'))
                                        ->pluck('kabupaten', 'id'))
                                    ->searchable()
                                    ->required()
                                    ->live()
                                    ->native(false)
                                    ->hidden(fn (Get $get) =>
                                    $get('al_ik_tgldi_ln') == 1 ||
                                        $get('ik_kk_sama_ak') == 1 ||
                                        $get('ik_status') == 'Sudah Meninggal' ||
                                        $get('ik_status') == 'Tidak Diketahui' ||
                                        $get('ik_status') == ''),

                                Forms\Components\Select::make('al_ik_kecamatan_id')
                                    ->label('Kecamatan')
                                    ->placeholder('Pilih Kecamatan')
                                    ->options(fn (Get $get): Collection => Kecamatan::query()
                                        ->where('kabupaten_id', $get('al_ik_kabupaten_id'))
                                        ->pluck('kecamatan', 'id'))
                                    ->searchable()
                                    ->required()
                                    ->live()
                                    ->native(false)
                                    ->hidden(fn (Get $get) =>
                                    $get('al_ik_tgldi_ln') == 1 ||
                                        $get('ik_kk_sama_ak') == 1 ||
                                        $get('ik_status') == 'Sudah Meninggal' ||
                                        $get('ik_status') == 'Tidak Diketahui' ||
                                        $get('ik_status') == ''),

                                Forms\Components\Select::make('al_ik_kelurahan_id')
                                    ->label('Kelurahan')
                                    ->placeholder('Pilih Kelurahan')
                                    ->options(fn (Get $get): Collection => Kelurahan::query()
                                        ->where('kecamatan_id', $get('al_ik_kecamatan_id'))
                                        ->pluck('kelurahan', 'id'))
                                    ->searchable()
                                    ->required()
                                    ->live()
                                    ->native(false)
                                    ->hidden(fn (Get $get) =>
                                    $get('al_ik_tgldi_ln') == 1 ||
                                        $get('ik_kk_sama_ak') == 1 ||
                                        $get('ik_status') == 'Sudah Meninggal' ||
                                        $get('ik_status') == 'Tidak Diketahui' ||
                                        $get('ik_status') == '')
                                    ->afterStateUpdated(function (Get $get, ?string $state, Set $set, ?string $old) {

                                        if (($get('al_ik_kodepos') ?? '') !== Str::slug($old)) {
                                            return;
                                        }

                                        $kodepos = Kodepos::where('kelurahan_id', $state)->get('kodepos');

                                        $state = $kodepos;

                                        foreach ($state as $state) {
                                            $set('al_ik_kodepos', Str::substr($state, 12, 5));
                                        }
                                    }),


                                Forms\Components\TextInput::make('al_ik_rt')
                                    ->label('RT')
                                    ->required()
                                    ->hidden(fn (Get $get) =>
                                    $get('al_ik_tgldi_ln') == 1 ||
                                        $get('ik_kk_sama_ak') == 1 ||
                                        $get('ik_status') == 'Sudah Meninggal' ||
                                        $get('ik_status') == 'Tidak Diketahui' ||
                                        $get('ik_status') == ''),

                                Forms\Components\TextInput::make('al_ik_rw')
                                    ->label('RW')
                                    ->required()
                                    ->hidden(fn (Get $get) =>
                                    $get('al_ik_tgldi_ln') == 1 ||
                                        $get('ik_kk_sama_ak') == 1 ||
                                        $get('ik_status') == 'Sudah Meninggal' ||
                                        $get('ik_status') == 'Tidak Diketahui' ||
                                        $get('ik_status') == ''),

                                Forms\Components\Textarea::make('al_ik_alamat')
                                    ->label('Alamat')
                                    ->required()
                                    ->columnSpanFull()
                                    ->hidden(fn (Get $get) =>
                                    $get('al_ik_tgldi_ln') == 1 ||
                                        $get('ik_kk_sama_ak') == 1 ||
                                        $get('ik_status') == 'Sudah Meninggal' ||
                                        $get('ik_status') == 'Tidak Diketahui' ||
                                        $get('ik_status') == ''),

                                Forms\Components\TextInput::make('al_ik_kodepos')
                                    ->label('Kodepos')
                                    ->disabled()
                                    ->required()
                                    ->hidden(fn (Get $get) =>
                                    $get('al_ik_tgldi_ln') == 1 ||
                                        $get('ik_kk_sama_ak') == 1 ||
                                        $get('ik_status') == 'Sudah Meninggal' ||
                                        $get('ik_status') == 'Tidak Diketahui' ||
                                        $get('ik_status') == ''),
                            ]),



                    ]),

                //WALI
                Section::make('')
                    ->schema([

                        Placeholder::make('')
                            ->content(new HtmlString('<div class="border-b">
                                                        <p class="text-2xl strong"><strong>C. WALI</strong></p>
                                                    </div>')),

                        Forms\Components\Select::make('w_status')
                            ->label('Status')
                            ->placeholder('Pilih Status')
                            ->options(function (Get $get) {

                                if (($get('ak_status') == "Masih Hidup" && $get('ik_status') == "Masih Hidup")) {
                                    return ([
                                        'Sama dengan ayah kandung' => 'Sama dengan ayah kandung',
                                        'Sama dengan ibu kandung' => 'Sama dengan ibu kandung',
                                        'Lainnya' => 'Lainnya'
                                    ]);
                                } elseif (($get('ak_status') == "Masih Hidup" && $get('ik_status') !== "Masih Hidup")) {
                                    return ([
                                        'Sama dengan ayah kandung' => 'Sama dengan ayah kandung',
                                        'Lainnya' => 'Lainnya'
                                    ]);
                                } elseif (($get('ak_status') !== "Masih Hidup" && $get('ik_status') == "Masih Hidup")) {
                                    return ([
                                        'Sama dengan ibu kandung' => 'Sama dengan ibu kandung',
                                        'Lainnya' => 'Lainnya'
                                    ]);
                                } elseif (($get('ak_status') !== "Masih Hidup" && $get('ik_status') !== "Masih Hidup")) {
                                    return ([
                                        'Lainnya' => 'Lainnya'
                                    ]);
                                }
                            })
                            ->required()
                            ->live()
                            ->native(false),

                        Forms\Components\TextInput::make('w_nama_lengkap')
                            ->label('Nama Lengkap')
                            ->hint('Isi sesuai dengan KK')
                            ->hintColor('danger')
                            ->required()
                            ->hidden(fn (Get $get) =>
                            $get('w_status') !== 'Lainnya'),

                        Placeholder::make('')
                            ->content(new HtmlString('<div class="border-b">
                                                        <p class="text-2xl strong"><strong>C.01 STATUS WALI</strong></p>
                                                    </div>'))
                            ->hidden(fn (Get $get) =>
                            $get('w_status') !== 'Lainnya'),

                        Forms\Components\Select::make('w_kewarganegaraan')
                            ->label('Kewarganegaraan')
                            ->placeholder('Pilih Kewarganegaraan')
                            ->options([
                                'WNI' => 'WNI',
                                'WNA' => 'WNA',
                            ])
                            ->required()
                            ->live()
                            ->native(false)
                            ->hidden(fn (Get $get) =>
                            $get('w_status') !== 'Lainnya'),

                        Forms\Components\TextInput::make('w_nik')
                            ->label('NIK')
                            ->hint('Isi sesuai dengan KK')
                            ->hintColor('danger')
                            ->length(16)
                            ->required()
                            ->hidden(fn (Get $get) =>
                            $get('w_kewarganegaraan') == 'WNA' ||
                                $get('w_kewarganegaraan') == '' ||
                                $get('w_status') !== 'Lainnya'),

                        Grid::make(2)
                            ->schema([

                                Forms\Components\TextInput::make('w_asal_negara')
                                    ->label('Asal Negara')
                                    ->required()
                                    ->hidden(fn (Get $get) =>
                                    $get('w_kewarganegaraan') == 'WNI' ||
                                        $get('w_kewarganegaraan') == '' ||
                                        $get('w_status') !== 'Lainnya'),

                                Forms\Components\TextInput::make('w_kitas')
                                    ->label('KITAS')
                                    ->hint('Nomor Izin Tinggal (KITAS)')
                                    ->hintColor('danger')
                                    ->required()
                                    ->hidden(fn (Get $get) =>
                                    $get('w_kewarganegaraan') == 'WNI' ||
                                        $get('w_kewarganegaraan') == '' ||
                                        $get('w_status') !== 'Lainnya'),
                            ]),

                        Grid::make(2)
                            ->schema([

                                Forms\Components\TextInput::make('w_tempat_lahir')
                                    ->label('Tempat Lahir')
                                    ->hint('Isi sesuai dengan KK')
                                    ->hintColor('danger')
                                    ->required()
                                    ->hidden(fn (Get $get) =>
                                    $get('w_status') !== 'Lainnya'),

                                Forms\Components\DatePicker::make('w_tanggal_lahir')
                                    ->label('Tanggal Lahir')
                                    ->hint('Isi sesuai dengan KK')
                                    ->hintColor('danger')
                                    ->required()
                                    // ->format('dd/mm/yyyy')
                                    ->displayFormat('d M Y')
                                    ->native(false)
                                    ->closeOnDateSelection()
                                    ->hidden(fn (Get $get) =>
                                    $get('w_status') !== 'Lainnya'),
                            ]),

                        Grid::make(3)
                            ->schema([

                                Forms\Components\Select::make('w_pend_terakhir')
                                    ->label('Pendidikan Terakhir')
                                    ->placeholder('Pilih Pendidikan Terakhir')
                                    ->options([
                                        'SD/Sederajat' => 'SD/Sederajat',
                                        'SMP/Sederajat' => 'SMP/Sederajat',
                                        'SMA/Sederajat' => 'SMA/Sederajat',
                                        'D1' => 'D1',
                                        'D2' => 'D2',
                                        'D3' => 'D3',
                                        'D4/S1' => 'D4/S1',
                                        'S2' => 'S2',
                                        'S3' => 'S3',
                                        'Tidak Bersekolah' => 'Tidak Bersekolah',
                                    ])
                                    ->searchable()
                                    ->required()
                                    ->live()
                                    ->native(false)
                                    ->hidden(fn (Get $get) =>
                                    $get('w_status') !== 'Lainnya'),

                                Forms\Components\Select::make('w_pekerjaan_utama')
                                    ->label('Pekerjaan Utama')
                                    ->placeholder('Pilih Pekerjaan Utama')
                                    ->options([
                                        'Tidak Bekerja' => 'Tidak Bekerja',
                                        'Pensiunan' => 'Pensiunan',
                                        'PNS' => 'PNS',
                                        'TNI/Polisi' => 'TNI/Polisi',
                                        'Guru/Dosen' => 'Guru/Dosen',
                                        'Pegawai Swasta' => 'Pegawai Swasta',
                                        'Wiraswasta' => 'Wiraswasta',
                                        'Pengacara/Jaksa/Hakim/Notaris' => 'Pengacara/Jaksa/Hakim/Notaris',
                                        'Seniman/Pelukis/Artis/Sejenis' => 'Seniman/Pelukis/Artis/Sejenis',
                                        'Dokter/Bidan/Perawat' => 'Dokter/Bidan/Perawat',
                                        'Pilot/Pramugara' => 'Pilot/Pramugara',
                                        'Pedagang' => 'Pedagang',
                                        'Petani/Peternak' => 'Petani/Peternak',
                                        'Nelayan' => 'Nelayan',
                                        'Buruh (Tani/Pabrik/Bangunan)' => 'Buruh (Tani/Pabrik/Bangunan)',
                                        'Sopir/Masinis/Kondektur' => 'Sopir/Masinis/Kondektur',
                                        'Politikus' => 'Politikus',
                                        'Lainnya' => 'Lainnya',
                                    ])
                                    ->searchable()
                                    ->required()
                                    ->live()
                                    ->native(false)
                                    ->hidden(fn (Get $get) =>
                                    $get('w_status') !== 'Lainnya'),

                                Forms\Components\Select::make('w_pghsln_rt')
                                    ->label('Penghasilan Rata-Rata')
                                    ->placeholder('Pilih Penghasilan Rata-Rata')
                                    ->options([
                                        'Kurang dari 500.000' => 'Kurang dari 500.000',
                                        '500.000 - 1.000.000' => '500.000 - 1.000.000',
                                        '1.000.001 - 2.000.000' => '1.000.001 - 2.000.000',
                                        '2.000.001 - 3.000.000' => '2.000.001 - 3.000.000',
                                        '3.000.001 - 5.000.000' => '3.000.001 - 5.000.000',
                                        'Lebih dari 5.000.000' => 'Lebih dari 5.000.000',
                                        'Tidak ada' => 'Tidak ada',
                                    ])
                                    ->searchable()
                                    ->required()
                                    ->live()
                                    ->native(false)
                                    ->hidden(fn (Get $get) =>
                                    $get('w_status') !== 'Lainnya'),
                            ]),

                        Grid::make(1)
                            ->schema([

                                Toggle::make('w_tdk_hp')
                                    ->label('Tidak memiliki nomer handphone')
                                    ->live()
                                    ->hidden(fn (Get $get) =>
                                    $get('w_status') !== 'Lainnya'),

                                Forms\Components\TextInput::make('w_nomor_handphone')
                                    ->label('No. Handphone')
                                    ->helperText('Contoh: 6282187782223')
                                    ->tel()
                                    ->telRegex('/^[+]*[(]{0,1}[0-9]{1,4}[)]{0,1}[-\s\.\/0-9]*$/')
                                    ->required()
                                    ->hidden(fn (Get $get) =>
                                    $get('w_tdk_hp') == 1 ||
                                        $get('w_status') !== 'Lainnya'),
                            ]),

                        // KARTU KELUARGA WALI
                        Placeholder::make('')
                            ->content(new HtmlString('<div class="border-b">
                             <p class="text-2xl strong"><strong>C.02 KARTU KELUARGA</strong></p>
                             <p class="text-2xl strong"><strong>WALI</strong></p>
                         </div>'))
                            ->hidden(fn (Get $get) =>
                            $get('w_status') !== 'Lainnya'),

                        Grid::make(2)
                            ->schema([

                                Forms\Components\TextInput::make('w_no_kk')
                                    ->label('No. KK Wali')
                                    ->hint('Isi sesuai dengan KK')
                                    ->hintColor('danger')
                                    ->length(16)
                                    ->required()
                                    ->hidden(fn (Get $get) =>
                                    $get('w_status') !== 'Lainnya'),

                                Forms\Components\TextInput::make('w_kep_kel_kk')
                                    ->label('Nama Kepala Keluarga')
                                    ->hint('Isi sesuai dengan KK')
                                    ->hintColor('danger')
                                    ->required()
                                    ->hidden(fn (Get $get) =>
                                    $get('w_status') !== 'Lainnya'),

                                Forms\Components\FileUpload::make('w_file_kk')
                                    ->label('Upload KK')
                                    ->hint('File PDF')
                                    ->hintColor('danger')
                                    ->helperText('Maks. 2 Mb')
                                    ->directory('walisantri/wali/kk')
                                    ->preserveFilenames()
                                    ->acceptedFileTypes(['application/pdf'])
                                    ->maxSize(2000)
                                    ->required()
                                    ->hidden(fn (Get $get) =>
                                    $get('w_status') !== 'Lainnya'),
                            ]),

                        // ALAMAT IBU KANDUNG
                        Placeholder::make('')
                            ->content(new HtmlString('<div class="border-b">
                                                        <p class="text-2xl strong"><strong>C.03 TEMPAT TINGGAL DOMISILI</strong></p>
                                                        <p class="text-2xl strong"><strong>WALI</strong></p>
                                                    </div>'))
                            ->hidden(fn (Get $get) =>
                            $get('w_status') !== 'Lainnya'),

                        Toggle::make('al_w_tgldi_ln')
                            ->label('Tinggal di luar negeri')
                            ->live()
                            ->hidden(fn (Get $get) =>
                            $get('w_status') !== 'Lainnya'),

                        Forms\Components\Textarea::make('al_w_almt_ln')
                            ->label('Alamat Luar Negeri')
                            ->required()
                            ->hidden(fn (Get $get) =>
                            $get('al_w_tgldi_ln') == 0 ||
                                $get('w_status') !== 'Lainnya'),

                        Forms\Components\Select::make('al_w_stts_rmh')
                            ->label('Status Kepemilikan Rumah')
                            ->placeholder('Pilih Status Kepemilikan Rumah')
                            ->options([
                                'Milik Sendiri' => 'Milik Sendiri',
                                'Rumah Orang Tua' => 'Rumah Orang Tua',
                                'Rumah Saudara/kerabat' => 'Rumah Saudara/kerabat',
                                'Rumah Dinas' => 'Rumah Dinas',
                                'Sewa/kontrak' => 'Sewa/kontrak',
                                'Lainnya' => 'Lainnya',
                            ])
                            ->searchable()
                            ->required()
                            ->live()
                            ->native(false)
                            ->hidden(fn (Get $get) =>
                            $get('al_w_tgldi_ln') == 1 ||
                                $get('w_status') !== 'Lainnya'),

                        Grid::make(2)
                            ->schema([

                                Forms\Components\Select::make('al_w_provinsi_id')
                                    ->label('Provinsi')
                                    ->placeholder('Pilih Provinsi')
                                    ->options(Provinsi::all()->pluck('provinsi', 'id'))
                                    ->searchable()
                                    ->required()
                                    ->live()
                                    ->native(false)
                                    ->hidden(fn (Get $get) =>
                                    $get('al_w_tgldi_ln') == 1 ||
                                        $get('w_status') !== 'Lainnya')
                                    ->afterStateUpdated(function (Set $set) {
                                        $set('al_w_kabupaten_id', null);
                                        $set('al_w_kecamatan_id', null);
                                        $set('al_w_kelurahan_id', null);
                                        $set('al_w_kodepos', null);
                                    }),

                                Forms\Components\Select::make('al_w_kabupaten_id')
                                    ->label('Kabupaten')
                                    ->placeholder('Pilih Kabupaten')
                                    ->options(fn (Get $get): Collection => Kabupaten::query()
                                        ->where('provinsi_id', $get('al_w_provinsi_id'))
                                        ->pluck('kabupaten', 'id'))
                                    ->searchable()
                                    ->required()
                                    ->live()
                                    ->native(false)
                                    ->hidden(fn (Get $get) =>
                                    $get('al_w_tgldi_ln') == 1 ||
                                        $get('w_status') !== 'Lainnya'),

                                Forms\Components\Select::make('al_w_kecamatan_id')
                                    ->label('Kecamatan')
                                    ->placeholder('Pilih Kecamatan')
                                    ->options(fn (Get $get): Collection => Kecamatan::query()
                                        ->where('kabupaten_id', $get('al_w_kabupaten_id'))
                                        ->pluck('kecamatan', 'id'))
                                    ->searchable()
                                    ->required()
                                    ->live()
                                    ->native(false)
                                    ->hidden(fn (Get $get) =>
                                    $get('al_w_tgldi_ln') == 1 ||
                                        $get('w_status') !== 'Lainnya'),

                                Forms\Components\Select::make('al_w_kelurahan_id')
                                    ->label('Kelurahan')
                                    ->placeholder('Pilih Kelurahan')
                                    ->options(fn (Get $get): Collection => Kelurahan::query()
                                        ->where('kecamatan_id', $get('al_w_kecamatan_id'))
                                        ->pluck('kelurahan', 'id'))
                                    ->searchable()
                                    ->required()
                                    ->live()
                                    ->native(false)
                                    ->hidden(fn (Get $get) =>
                                    $get('al_w_tgldi_ln') == 1 ||
                                        $get('w_status') !== 'Lainnya')
                                    ->afterStateUpdated(function (Get $get, ?string $state, Set $set, ?string $old) {

                                        if (($get('al_w_kodepos') ?? '') !== Str::slug($old)) {
                                            return;
                                        }

                                        $kodepos = Kodepos::where('kelurahan_id', $state)->get('kodepos');

                                        $state = $kodepos;

                                        foreach ($state as $state) {
                                            $set('al_w_kodepos', Str::substr($state, 12, 5));
                                        }
                                    }),


                                Forms\Components\TextInput::make('al_w_rt')
                                    ->label('RT')
                                    ->required()
                                    ->hidden(fn (Get $get) =>
                                    $get('al_w_tgldi_ln') == 1 ||
                                        $get('w_status') !== 'Lainnya'),

                                Forms\Components\TextInput::make('al_w_rw')
                                    ->label('RW')
                                    ->required()
                                    ->hidden(fn (Get $get) =>
                                    $get('al_w_tgldi_ln') == 1 ||
                                        $get('w_status') !== 'Lainnya'),

                                Forms\Components\Textarea::make('al_w_alamat')
                                    ->label('Alamat')
                                    ->required()
                                    ->columnSpanFull()
                                    ->hidden(fn (Get $get) =>
                                    $get('al_w_tgldi_ln') == 1 ||
                                        $get('w_status') !== 'Lainnya'),

                                Forms\Components\TextInput::make('al_w_kodepos')
                                    ->label('Kodepos')
                                    ->disabled()
                                    ->required()
                                    ->hidden(fn (Get $get) =>
                                    $get('al_w_tgldi_ln') == 1 ||
                                        $get('w_status') !== 'Lainnya'),
                            ]),



                    ]),



            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('kartu_keluarga')
                    ->searchable(),
                Tables\Columns\TextColumn::make('ak_nama_lengkap')
                    ->searchable(),
                Tables\Columns\TextColumn::make('ak_status')
                    ->searchable(),
                Tables\Columns\TextColumn::make('ak_kewarganegaraan')
                    ->searchable(),
                Tables\Columns\TextColumn::make('ak_asal_negara')
                    ->searchable(),
                Tables\Columns\TextColumn::make('ak_kitas')
                    ->searchable(),
                Tables\Columns\TextColumn::make('ak_nik')
                    ->searchable(),
                Tables\Columns\TextColumn::make('ak_tempat_lahir')
                    ->searchable(),
                Tables\Columns\TextColumn::make('ak_tanggal_lahir')
                    ->searchable(),
                Tables\Columns\TextColumn::make('ak_pend_terakhir')
                    ->searchable(),
                Tables\Columns\TextColumn::make('ak_pekerjaan_utama')
                    ->searchable(),
                Tables\Columns\TextColumn::make('ak_pghsln_rt')
                    ->searchable(),
                Tables\Columns\IconColumn::make('ak_tdk_hp')
                    ->boolean(),
                Tables\Columns\TextColumn::make('ak_nomor_handphone')
                    ->searchable(),
                Tables\Columns\TextColumn::make('file_kk')
                    ->searchable(),
                Tables\Columns\TextColumn::make('ik_nama_lengkap')
                    ->searchable(),
                Tables\Columns\TextColumn::make('ik_status')
                    ->searchable(),
                Tables\Columns\TextColumn::make('ik_kewarganegaraan')
                    ->searchable(),
                Tables\Columns\TextColumn::make('ik_asal_negara')
                    ->searchable(),
                Tables\Columns\TextColumn::make('ik_kitas')
                    ->searchable(),
                Tables\Columns\TextColumn::make('ik_nik')
                    ->searchable(),
                Tables\Columns\TextColumn::make('ik_tempat_lahir')
                    ->searchable(),
                Tables\Columns\TextColumn::make('ik_tanggal_lahir')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('ik_pend_terakhir')
                    ->searchable(),
                Tables\Columns\TextColumn::make('ik_pekerjaan_utama')
                    ->searchable(),
                Tables\Columns\TextColumn::make('ik_pghsln_rt')
                    ->searchable(),
                Tables\Columns\IconColumn::make('ik_tdk_hp')
                    ->boolean(),
                Tables\Columns\TextColumn::make('ik_nomor_handphone')
                    ->searchable(),
                Tables\Columns\IconColumn::make('ik_kk_sama_ak')
                    ->boolean(),
                Tables\Columns\TextColumn::make('w_status')
                    ->searchable(),
                Tables\Columns\TextColumn::make('w_nama_lengkap')
                    ->searchable(),
                Tables\Columns\TextColumn::make('w_kewarganegaraan')
                    ->searchable(),
                Tables\Columns\TextColumn::make('w_asal_negara')
                    ->searchable(),
                Tables\Columns\TextColumn::make('w_kitas')
                    ->searchable(),
                Tables\Columns\TextColumn::make('w_nik')
                    ->searchable(),
                Tables\Columns\TextColumn::make('w_tempat_lahir')
                    ->searchable(),
                Tables\Columns\TextColumn::make('w_tanggal_lahir')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('w_pend_terakhir')
                    ->searchable(),
                Tables\Columns\TextColumn::make('w_pekerjaan_utama')
                    ->searchable(),
                Tables\Columns\TextColumn::make('w_pghsln_rt')
                    ->searchable(),
                Tables\Columns\IconColumn::make('w_tdk_hp')
                    ->boolean(),
                Tables\Columns\TextColumn::make('w_nomor_handphone')
                    ->searchable(),
                Tables\Columns\IconColumn::make('al_ak_tgldi_ln')
                    ->boolean(),
                Tables\Columns\TextColumn::make('al_ak_stts_rmh')
                    ->searchable(),
                Tables\Columns\TextColumn::make('al_ak_provinsi_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('al_ak_kabupaten_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('al_ak_kecamatan_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('al_ak_kelurahan_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('al_ak_rt')
                    ->searchable(),
                Tables\Columns\TextColumn::make('al_ak_rw')
                    ->searchable(),
                Tables\Columns\TextColumn::make('al_ak_alamat')
                    ->searchable(),
                Tables\Columns\TextColumn::make('al_ak_kodepos')
                    ->searchable(),
                Tables\Columns\IconColumn::make('al_ik_sama_ak')
                    ->boolean(),
                Tables\Columns\IconColumn::make('al_ik_tgldi_ln')
                    ->boolean(),
                Tables\Columns\TextColumn::make('al_ik_stts_rmh')
                    ->searchable(),
                Tables\Columns\TextColumn::make('al_ik_provinsi_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('al_ik_kabupaten_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('al_ik_kecamatan_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('al_ik_kelurahan_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('al_ik_rt')
                    ->searchable(),
                Tables\Columns\TextColumn::make('al_ik_rw')
                    ->searchable(),
                Tables\Columns\TextColumn::make('al_ik_kodepos')
                    ->searchable(),
                Tables\Columns\TextColumn::make('al_w_dmsl')
                    ->searchable(),
                Tables\Columns\IconColumn::make('al_w_tgldi_ln')
                    ->boolean(),
                Tables\Columns\TextColumn::make('al_w_stts_rmh')
                    ->searchable(),
                Tables\Columns\TextColumn::make('al_w_provinsi_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('al_w_kabupaten_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('al_w_kecamatan_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('al_w_kelurahan_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('al_w_rt')
                    ->searchable(),
                Tables\Columns\TextColumn::make('al_w_rw')
                    ->searchable(),
                Tables\Columns\TextColumn::make('al_w_kodepos')
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
            'index' => Pages\ListWalisantris::route('/'),
            'create' => Pages\CreateWalisantri::route('/create'),
            'view' => Pages\ViewWalisantri::route('/{record}'),
            'edit' => Pages\EditWalisantri::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->whereHas('user', function ($query) {
            $query->where('id', Auth::user()->id);
        });
    }
}
