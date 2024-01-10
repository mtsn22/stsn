<?php

namespace App\Filament\Pengajar\Resources;

use App\Filament\Pengajar\Resources\PendaftarResource\Pages;
use App\Filament\Pengajar\Resources\PendaftarResource\RelationManagers;
use App\Filament\Pengajar\Resources\PendaftarResource\Widgets\JumlahPendaftar;
use App\Models\Pendaftar;
use App\Models\Santri;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\Layout\Split;
use Filament\Tables\Columns\Layout\Stack;
use Filament\Tables\Columns\SelectColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Enums\ActionsPosition;
use Illuminate\Support\Str;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\HtmlString;

class PendaftarResource extends Resource
{
    protected static ?string $model = Pendaftar::class;

    protected static ?string $modelLabel = 'Pendaftar TN & MTW';

    protected static ?string $navigationLabel = 'Pendaftar TN & MTW';

    protected static ?string $pluralModelLabel = 'Pendaftar TN & MTW';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                Section::make('')
                    ->schema([
                        Placeholder::make('')
                            ->content(new HtmlString('<div class="">
                                         <p>Butuh bantuan?</p>
                                         <p>Silakan mengubungi admin di bawah ini melalui WA:</p>
                                         <p class="text-tsn-header"><a href="https://wa.me/6282210862400">> Link WA Admin Putra <</a></p>
                                         <p class="text-tsn-header"><a href="https://wa.me/6281232171109">> Link WA Admin Putri <</a></p>
                                     </div>')),
                    ]),

                Section::make('')
                    ->schema([
                        TextInput::make('qism_calon_view')
                            ->label('Qism yang dituju')
                            ->default('Tarbiyatunnisaa')
                            ->disabled()
                            ->required()
                            ->dehydrated()
                            ->live(),

                        Hidden::make('qism_calon')
                            ->default('6'),

                        TextInput::make('telp_calon')
                            ->label('Nomor WA walisantri')
                            ->tel()
                            ->telRegex('/^[+]*[(]{0,1}[0-9]{1,4}[)]{0,1}[-\s\.\/0-9]*$/')
                            ->required()
                            ->disabled(),
                    ]),

                Section::make('')
                    ->schema([
                        Placeholder::make('')
                            ->content(new HtmlString('<div class="border-b">
                                                    <p class="text-xl strong"><strong>A. CALON SANTRI</strong></p>
                                                </div>')),

                        TextInput::make('kk_calon')
                            ->label('Nomor KK Calon Santri')
                            ->hintColor('danger')
                            ->default('1234567891234565')
                            ->length(16)
                            ->required()
                            ->disabled()
                            ->live(),

                        TextInput::make('nik_calon')
                            ->label('Nomor NIK Calon Santri')
                            ->hintColor('danger')
                            ->default('')
                            ->length(16)
                            ->required()
                            // ->unique(Pendaftar::class, 'nik_calon')
                            // ->unique(Santri::class, 'nik')
                            ->unique(ignoreRecord: true)
                            ->disabled(),

                        TextInput::make('nama_calon')
                            ->label('Nama Asli')
                            ->default('s')
                            ->hintColor('danger')
                            ->required()
                            ->disabled(),

                        TextInput::make('nama_panggilan_calon')
                            ->label('Nama Hijroh')
                            ->default('s')
                            ->required()
                            ->disabled(),

                        TextInput::make('tempat_lahir_calon')
                            ->label('Tempat Lahir')
                            ->default('s')
                            ->hintColor('danger')
                            ->required()
                            ->disabled(),

                        DatePicker::make('tanggal_lahir_calon')
                            ->label('Tanggal Lahir ')
                            ->hintColor('danger')
                            ->default('11111111')
                            ->required()
                            // ->native(false)
                            ->closeOnDateSelection()
                            ->disabled(),

                        TextInput::make('umur_calon')
                            ->label('Umur')
                            ->default('s')
                            ->required()
                            ->disabled(),

                        Textarea::make('al_s_alamat_calon')
                            ->label('Alamat')
                            ->default('s')
                            ->required()
                            ->disabled(),

                        TextInput::make('peng_pend_formal_calon')
                            ->label('Pengalaman Pendidikan Formal')
                            ->default('s')
                            ->required()
                            ->disabled(),

                        TextInput::make('peng_pend_agama_calon')
                            ->label('Pengalaman Pendidikan Agama (mondok)')
                            ->default('s')
                            ->required()
                            ->disabled(),

                        TextArea::make('peny_fisik_calon')
                            ->label('Riwayat Penyakit Fisik')
                            ->default('s')
                            ->required(),

                        TextArea::make('peny_non_fisik_calon')
                            ->label('Riwayat penyakit non fisik (terkena jin atau penyakit kejiwaan)')
                            ->default('s')
                            ->required()
                            ->disabled(),

                        TextArea::make('akun_medsos_calon')
                            ->label('Akun Medsos yang Pernah Dimiliki')
                            ->default('s')
                            ->required()
                            ->disabled(),

                        Radio::make('akun_medsos_aktif_calon')
                            ->label('Apakah masih aktif hingga kini?')
                            ->options([
                                'Aktif' => 'Aktif',
                                'Tidak Aktif' => 'Tidak Aktif',
                            ])
                            ->required()
                            ->default('Aktif')
                            ->inline()
                            ->disabled(),

                        Placeholder::make('')
                            ->content(new HtmlString('<div class="border-b">
                                                    <p class="text-lg strong"><strong>Status Calon Santri</strong></p>
                                                </div>')),

                        Radio::make('status_mampu_calon')
                            ->label('Status calon anak didik')
                            ->options([
                                'Santriwati mampu (tidak ada permasalahn biaya)' => 'Santriwati mampu (tidak ada permasalahn biaya)',
                                'Santriwati kurang mampu (ada permasalahan biaya)' => 'Santriwati kurang mampu (ada permasalahan biaya)',
                            ])
                            ->live()
                            ->required()
                            ->default('Santriwati kurang mampu (ada permasalahan biaya)')
                            ->inline()
                            ->disabled(),

                        Textarea::make('rincian_status_mampu_calon')
                            ->label('Dengan merincikan ketidakmampuannya untuk dipertimbangkan')
                            ->required()
                            ->hidden(fn (Get $get) =>
                            $get('status_mampu_calon') !== 'Santriwati kurang mampu (ada permasalahan biaya)' ||
                                $get('status_mampu_calon') == '')
                            ->default('s')
                            ->disabled(),

                        Select::make('mendaftar_keinginan_calon')
                            ->label('Mendaftar atas kenginginan')
                            ->options([
                                'Orangtua' => 'Orangtua',
                                'Ananda' => 'Ananda',
                                'Lainnya' => 'Lainnya',
                            ])
                            ->required()
                            ->live()
                            ->default('Lainnya')
                            ->disabled(),

                        TextInput::make('mendaftar_keinginan_lainnya_calon')
                            ->label('Lainnya')
                            ->required()
                            ->default('Lainnya')
                            ->hidden(fn (Get $get) =>
                            $get('mendaftar_keinginan_calon') !== 'Lainnya' ||
                                $get('mendaftar_keinginan_calon') == '')
                            ->disabled(),



                    ]),



                Section::make('')
                    ->schema([

                        Placeholder::make('')
                            ->content(new HtmlString('<div class="border-b">
                                                    <p class="text-xl strong"><strong>B. ORANG TUA</strong></p>
                                                </div>')),

                        Placeholder::make('')
                            ->content(new HtmlString('<div class="border-b">
                                                    <p class="text-lg strong"><strong>B.1 Ayah Kandung</strong></p>
                                                </div>')),

                        TextInput::make('ak_nama_lengkap_calon')
                            ->label('Nama Ayah Kandung')
                            ->hintColor('danger')
                            ->default('Lainnya')
                            ->required()
                            ->disabled(),

                        Select::make('ak_status_calon')
                            ->label('Status')
                            ->placeholder('Pilih Status')
                            ->options([
                                'Masih Hidup' => 'Masih Hidup',
                                'Sudah Meninggal' => 'Sudah Meninggal',
                                'Tidak Diketahui' => 'Tidak Diketahui',
                            ])
                            ->required()
                            ->default('Masih Hidup')
                            ->live()
                            ->disabled(),
                        // ->native(false),

                        TextInput::make('ak_nama_kunyah_calon')
                            ->label('Nama Kunyah')
                            ->required()
                            ->default('d')
                            ->hidden(fn (Get $get) =>
                            $get('ak_status_calon') == 'Sudah Meninggal' ||
                                $get('ak_status_calon') == 'Tidak Diketahui' ||
                                $get('ak_status_calon') == '')
                            ->disabled(),

                        Select::make('ak_pekerjaan_utama_calon')
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
                            ->required()
                            ->hidden(fn (Get $get) =>
                            $get('ak_status_calon') == 'Sudah Meninggal' ||
                                $get('ak_status_calon') == 'Tidak Diketahui' ||
                                $get('ak_status_calon') == '')
                            ->default('Politikus')
                            ->disabled(),
                        // ->native(false),

                        Select::make('ak_pghsln_rt_calon')
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
                            // ->searchable()
                            ->required()
                            ->hidden(fn (Get $get) =>
                            $get('ak_status_calon') == 'Sudah Meninggal' ||
                                $get('ak_status_calon') == 'Tidak Diketahui' ||
                                $get('ak_status_calon') == '')
                            ->default('Lebih dari 5.000.000')
                            ->disabled(),
                        // ->native(false),

                        Placeholder::make('')
                            ->content(new HtmlString('<div class="border-b">
                                                    <p class="text-lg strong"><strong>Kajian yang Diikuti Ayah Kandung</strong></p>
                                                </div>'))
                            ->hidden(fn (Get $get) =>
                            $get('ak_status_calon') == 'Sudah Meninggal' ||
                                $get('ak_status_calon') == 'Tidak Diketahui' ||
                                $get('ak_status_calon') == ''),

                        Textarea::make('ak_ustadz_kajian_calon')
                            ->label('Ustadz yang mengisi kajian')
                            ->required()
                            ->default('a')
                            ->hidden(fn (Get $get) =>
                            $get('ak_status_calon') == 'Sudah Meninggal' ||
                                $get('ak_status_calon') == 'Tidak Diketahui' ||
                                $get('ak_status_calon') == '')
                            ->disabled(),

                        Textarea::make('ak_tempat_kajian_calon')
                            ->label('Tempat kajian yang diikuti')
                            ->required()
                            ->default('a')
                            ->hidden(fn (Get $get) =>
                            $get('ak_status_calon') == 'Sudah Meninggal' ||
                                $get('ak_status_calon') == 'Tidak Diketahui' ||
                                $get('ak_status_calon') == '')
                            ->disabled(),

                        Placeholder::make('')
                            ->content(new HtmlString('<div></div>')),

                        Placeholder::make('')
                            ->content(new HtmlString('<div class="border-b">
                                                    <p class="text-lg strong"><strong>B.2 Ibu Kandung</strong></p>
                                                </div>')),

                        TextInput::make('ik_nama_lengkap_calon')
                            ->label('Nama Ibu Kandung')
                            ->hintColor('danger')
                            ->default('a')
                            ->required()
                            ->disabled(),

                        Select::make('ik_status_calon')
                            ->label('Status')
                            ->placeholder('Pilih Status')
                            ->options([
                                'Masih Hidup' => 'Masih Hidup',
                                'Sudah Meninggal' => 'Sudah Meninggal',
                                'Tidak Diketahui' => 'Tidak Diketahui',
                            ])
                            ->required()
                            ->default('Masih Hidup')
                            ->live()
                            ->disabled(),
                        // ->native(false),

                        TextInput::make('ik_nama_kunyah_calon')
                            ->label('Nama Kunyah')
                            ->default('a')
                            ->required()
                            ->hidden(fn (Get $get) =>
                            $get('ik_status_calon') == 'Sudah Meninggal' ||
                                $get('ik_status_calon') == 'Tidak Diketahui' ||
                                $get('ik_status_calon') == '')
                            ->disabled(),

                        Select::make('ik_pekerjaan_utama_calon')
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
                            // ->searchable()
                            ->required()
                            ->default('Nelayan')
                            ->hidden(fn (Get $get) =>
                            $get('ik_status_calon') == 'Sudah Meninggal' ||
                                $get('ik_status_calon') == 'Tidak Diketahui' ||
                                $get('ik_status_calon') == '')
                            ->disabled(),
                        // ->native(false),

                        Select::make('ik_pghsln_rt_calon')
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
                            // ->searchable()
                            ->required()
                            ->default('3.000.001 - 5.000.000')
                            ->hidden(fn (Get $get) =>
                            $get('ik_status_calon') == 'Sudah Meninggal' ||
                                $get('ik_status_calon') == 'Tidak Diketahui' ||
                                $get('ik_status_calon') == '')
                            ->disabled(),
                        // ->native(false),

                        Placeholder::make('')
                            ->content(new HtmlString('<div class="border-b">
                                                    <p class="text-lg strong"><strong>Kajian yang Diikuti Ibu Kandung</strong></p>
                                                </div>'))
                            ->hidden(fn (Get $get) =>
                            $get('ik_status_calon') == 'Sudah Meninggal' ||
                                $get('ik_status_calon') == 'Tidak Diketahui' ||
                                $get('ik_status_calon') == '')
                            ->disabled(),

                        Textarea::make('ik_ustadz_kajian_calon')
                            ->label('Ustadz yang mengisi kajian')
                            ->required()
                            ->default('a')
                            ->hidden(fn (Get $get) =>
                            $get('ik_status_calon') == 'Sudah Meninggal' ||
                                $get('ik_status_calon') == 'Tidak Diketahui' ||
                                $get('ik_status_calon') == '')
                            ->disabled(),

                        Textarea::make('ik_tempat_kajian_calon')
                            ->label('Tempat kajian yang diikuti')
                            ->required()
                            ->default('a')
                            ->hidden(fn (Get $get) =>
                            $get('ik_status_calon') == 'Sudah Meninggal' ||
                                $get('ik_status_calon') == 'Tidak Diketahui' ||
                                $get('ik_status_calon') == '')
                            ->disabled(),
                    ]),


                Section::make('')
                    ->schema([
                        Placeholder::make('')
                            ->content(new HtmlString('<div class="border-b">
                                                    <p class="text-xl strong"><strong>B. WALI (ORANG YANG BERTANGGUNG JAWAB)</strong></p>
                                                </div>')),

                        Select::make('w_status_calon')
                            ->label('Status')
                            ->placeholder('Pilih Status')
                            ->options(function (Get $get) {

                                if (($get('ak_status_calon') == "Masih Hidup" && $get('ik_status_calon') == "Masih Hidup")) {
                                    return ([
                                        'Sama dengan ayah kandung' => 'Sama dengan ayah kandung',
                                        'Sama dengan ibu kandung' => 'Sama dengan ibu kandung',
                                        'Lainnya' => 'Lainnya'
                                    ]);
                                } elseif (($get('ak_status_calon') == "Masih Hidup" && $get('ik_status_calon') !== "Masih Hidup")) {
                                    return ([
                                        'Sama dengan ayah kandung' => 'Sama dengan ayah kandung',
                                        'Lainnya' => 'Lainnya'
                                    ]);
                                } elseif (($get('ak_status_calon') !== "Masih Hidup" && $get('ik_status_calon') == "Masih Hidup")) {
                                    return ([
                                        'Sama dengan ibu kandung' => 'Sama dengan ibu kandung',
                                        'Lainnya' => 'Lainnya'
                                    ]);
                                } elseif (($get('ak_status_calon') !== "Masih Hidup" && $get('ik_status_calon') !== "Masih Hidup")) {
                                    return ([
                                        'Lainnya' => 'Lainnya'
                                    ]);
                                }
                            })
                            ->required()
                            ->default('Sama dengan ayah kandung')
                            ->live()
                            ->disabled(),
                        // ->native(false),

                        Select::make('w_hubungan_calon')
                            ->label('Hubungan dengan calon santri')
                            ->options([
                                'Kakek/Nenek' => 'Kakek/Nenek',
                                'Paman/Bibi' => 'Paman/Bibi',
                                'Kakak' => 'Kakak',
                                'Lainnya' => 'Lainnya',
                            ])
                            // ->searchable()
                            ->required()
                            ->hidden(fn (Get $get) =>
                            $get('w_status_calon') !== 'Lainnya')
                            ->disabled(),
                        // ->native(false),

                        TextInput::make('w_nama_lengkap_calon')
                            ->label('Nama Wali')
                            ->hintColor('danger')
                            ->required()
                            ->hidden(fn (Get $get) =>
                            $get('w_status_calon') !== 'Lainnya')
                            ->disabled(),

                        TextInput::make('w_nama_kunyah_calon')
                            ->label('Nama Kunyah')
                            ->required()
                            ->hidden(fn (Get $get) =>
                            $get('w_status_calon') !== 'Lainnya')
                            ->disabled(),

                        Select::make('w_pekerjaan_utama_calon')
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
                            // ->searchable()
                            ->required()
                            ->hidden(fn (Get $get) =>
                            $get('w_status_calon') !== 'Lainnya')
                            ->disabled(),
                        // ->native(false),

                        Select::make('w_pghsln_rt_calon')
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
                            // ->searchable()
                            ->required()
                            ->hidden(fn (Get $get) =>
                            $get('w_status_calon') !== 'Lainnya')
                            ->disabled(),
                        // ->native(false),

                        Placeholder::make('')
                            ->content(new HtmlString('<div class="border-b">
                                                    <p class="text-lg strong"><strong>Kajian yang Diikuti Wali</strong></p>
                                                </div>'))
                            ->hidden(fn (Get $get) =>
                            $get('w_status_calon') !== 'Lainnya'),

                        Textarea::make('w_ustadz_kajian_calon')
                            ->label('Ustadz yang mengisi kajian')
                            ->required()
                            ->hidden(fn (Get $get) =>
                            $get('w_status_calon') !== 'Lainnya')
                            ->disabled(),

                        Textarea::make('w_tempat_kajian_calon')
                            ->label('Tempat kajian yang diikuti')
                            ->required()
                            ->hidden(fn (Get $get) =>
                            $get('w_status_calon') !== 'Lainnya')
                            ->disabled(),
                    ]),

                Section::make('')
                    ->schema([

                        Placeholder::make('')
                            ->content(new HtmlString('<div class="border-b">
                                                <p class="text-xl strong"><strong>TAHAP PENDAFTARAN CALON SANTRI</strong></p>
                                            </div>')),

                        Select::make('tahap')
                            ->label('Tahap')
                            ->options([
                                'Mendaftar' => 'Mendaftar',
                                'Diterima' => 'Diterima',
                            ])
                            // ->searchable()
                            ->required()
                            ->live()
                            ->afterStateUpdated(function (Get $get, Set $set) {

                                $kk = $get('kk_calon');

                                $cekusername = User::where('username', $kk)->count();

                                if ($cekusername == 0) {



                                    //replicate data to table users (Create user id)

                                    $set('user.username', $kk);
                                    $set('user.name', $get('ak_nama_lengkap_calon'));
                                    $set('user.panelrole', 'walisantri');
                                    $set('user.password', Str::camel($get('tanggal_lahir_calon')));

                                    //replicate data to table walisantris (Create Walisantri)
                                    $set('walisantri.ak_nama_lengkap', $get('ak_nama_lengkap_calon'));
                                    $set('walisantri.ak_status', $get('ak_status_calon'));
                                    $set('walisantri.ak_nama_kunyah', $get('ak_nama_kunyah_calon'));
                                    $set('walisantri.ak_pekerjaan_utama', $get('ak_pekerjaan_utama_calon'));
                                    $set('walisantri.ak_pghsln_rt', $get('ak_pghsln_rt_calon'));
                                    $set('walisantri.ak_ustadz_kajian', $get('ak_ustadz_kajian_calon'));
                                    $set('walisantri.ak_tempat_kajian', $get('ak_tempat_kajian_calon'));
                                    $set('walisantri.ik_nama_lengkap', $get('ik_nama_lengkap_calon'));
                                    $set('walisantri.ik_status', $get('ik_status_calon'));
                                    $set('walisantri.ik_nama_kunyah', $get('ik_nama_kunyah_calon'));
                                    $set('walisantri.ik_pekerjaan_utama', $get('ik_pekerjaan_utama_calon'));
                                    $set('walisantri.ik_pghsln_rt', $get('ik_pghsln_rt_calon'));
                                    $set('walisantri.ik_ustadz_kajian', $get('ik_ustadz_kajian_calon'));
                                    $set('walisantri.ik_tempat_kajian', $get('ik_tempat_kajian_calon'));
                                    $set('walisantri.w_status', $get('w_status_calon'));
                                    $set('walisantri.w_hubungan', $get('w_hubungan_calon'));
                                    $set('walisantri.w_nama_lengkap', $get('w_nama_lengkap_calon'));
                                    $set('walisantri.w_nama_kunyah', $get('w_nama_kunyah_calon'));
                                    $set('walisantri.w_pekerjaan_utama', $get('w_pekerjaan_utama_calon'));
                                    $set('walisantri.w_pghsln_rt', $get('w_pghsln_rt_calon'));
                                    $set('walisantri.w_ustadz_kajian', $get('w_ustadz_kajian_calon'));
                                    $set('walisantri.w_tempat_kajian', $get('w_tempat_kajian_calon'));
                                } elseif ($cekusername !== 0) {
                                    return;
                                }





                                // $kodepos = Kodepos::where('kelurahan_id', $state)->get('kodepos');

                                // $state = $kodepos;

                                // foreach ($state as $state) {
                                //     $set('al_w_kodepos', Str::substr($state, 12, 5));
                                // }
                            })->disableOptionWhen(fn (string $value): bool => $value !== 'Diterima'),

                        // })->disableOptionWhen(function (Get $get, string $value) {
                        //     if ($get('tahap') == 'Mendaftar'){
                        //         $value !== 'Mendaftar';
                        //         // $value === 'Diterima';
                        //     }

                        //     $value !== 'Diterima';
                        // } ),
                    ]),

                Fieldset::make('Data to Table users')
                    ->relationship('user')
                    ->schema([
                        TextInput::make('username'),
                        TextInput::make('name'),
                        TextInput::make('panelrole'),
                        TextInput::make('password'),
                    ]),



                // Fieldset::make('Data to Table walisantris')
                // ->relationship('walisantri')
                // ->schema([
                //     TextInput::make('ak_nama_lengkap'),
                //     TextInput::make('ak_status'),
                //     TextInput::make('ak_nama_kunyah'),
                //     TextInput::make('ak_pekerjaan_utama'),
                //     TextInput::make('ak_pghsln_rt'),
                //     TextInput::make('ak_ustadz_kajian'),
                //     TextInput::make('ak_tempat_kajian'),
                //     TextInput::make('ik_nama_lengkap'),
                //     TextInput::make('ik_status'),
                //     TextInput::make('ik_nama_kunyah'),
                //     TextInput::make('ik_pekerjaan_utama'),
                //     TextInput::make('ik_pghsln_rt'),
                //     TextInput::make('ik_ustadz_kajian'),
                //     TextInput::make('ik_tempat_kajian'),
                //     TextInput::make('w_status'),
                //     TextInput::make('w_hubungan'),
                //     TextInput::make('w_nama_lengkap'),
                //     TextInput::make('w_nama_kunyah'),
                //     TextInput::make('w_pekerjaan_utama'),
                //     TextInput::make('w_pghsln_rt'),
                //     TextInput::make('w_ustadz_kajian'),
                //     TextInput::make('w_tempat_kajian'),
                // ]),





                Hidden::make('jeniskelamin_calon')
                    ->default('Perempuan'),


            ])
            ->statePath('data');
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('tahap')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Mendaftar' => 'warning',
                        'Diterima' => 'success',
                    }),

                Tables\Columns\TextColumn::make('nama_calon')
                    ->label('Nama')
                    ->sortable()
                    ->searchable(),


                Tables\Columns\TextColumn::make('tempat_lahir_calon')
                    ->label('Tempat Lahir')
                    ->sortable(),

                Tables\Columns\TextColumn::make('tanggal_lahir_calon')
                    ->label('Tanggal Lahir')
                    ->sortable(),


                // Tables\Columns\TextColumn::make('nama_panggilan_calon')
                //     ->label('Kunyah')
                //     ->sortable()
                //     ->searchable(),
                // Tables\Columns\TextColumn::make('umur_calon')
                //     ->label('Umur')
                //     ->sortable()
                //     ->searchable(),
                // Tables\Columns\TextColumn::make('al_s_alamat_calon')
                //     ->label('Alamat')
                //     ->sortable()
                //     ->searchable(),
                // Tables\Columns\TextColumn::make('ak_nama_lengkap_calon')
                //     ->label('Nama Ayah Kandung')
                //     ->sortable()
                //     ->searchable(),
                // Tables\Columns\TextColumn::make('ik_nama_lengkap_calon')
                //     ->label('Nama Ibu Kandung')
                //     ->sortable()
                //     ->searchable(),
                // Tables\Columns\TextColumn::make('w_nama_lengkap_calon')
                //     ->label('Nama Wali')
                //     ->sortable()
                //     ->searchable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                // Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ], position: ActionsPosition::BeforeColumns)
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    // Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getWidgets(): array
    {
        return [
            JumlahPendaftar::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPendaftars::route('/'),
            // 'create' => Pages\CreatePendaftar::route('/create'),
            'view' => Pages\ViewPendaftar::route('/{record}'),
            'edit' => Pages\EditPendaftar::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->where('qism_calon', Auth::user()->mudirqism);
    }
}
