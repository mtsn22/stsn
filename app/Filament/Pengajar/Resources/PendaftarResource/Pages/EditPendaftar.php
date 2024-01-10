<?php

namespace App\Filament\Pengajar\Resources\PendaftarResource\Pages;

use App\Filament\Pengajar\Resources\PendaftarResource;
use App\Models\NismPerTahun;
use App\Models\Santri;
use App\Models\User;
use App\Models\Walisantri;
use DateTime;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Livewire\Attributes\On;
use Illuminate\Support\Str;

class EditPendaftar extends EditRecord
{
    protected static string $resource = PendaftarResource::class;

    protected function afterSave(): void
    {
        if (Walisantri::where('user_id', $this->record->user_id)->count() === 0) {

            $walisantri = new walisantri;

            $walisantri->user_id = $this->record->user_id;
            $walisantri->ak_nama_lengkap = $this->record->ak_nama_lengkap_calon;
            $walisantri->ak_status = $this->record->ak_status_calon;
            $walisantri->ak_nama_kunyah = $this->record->ak_nama_kunyah_calon;
            $walisantri->ak_pekerjaan_utama = $this->record->ak_pekerjaan_utama_calon;
            $walisantri->ak_pghsln_rt = $this->record->ak_pghsln_rt_calon;
            $walisantri->ak_ustadz_kajian = $this->record->ak_ustadz_kajian_calon;
            $walisantri->ak_tempat_kajian = $this->record->ak_tempat_kajian_calon;
            $walisantri->ik_nama_lengkap = $this->record->ik_nama_lengkap_calon;
            $walisantri->ik_status = $this->record->ik_status_calon;
            $walisantri->ik_nama_kunyah = $this->record->ik_nama_kunyah_calon;
            $walisantri->ik_pekerjaan_utama = $this->record->ik_pekerjaan_utama_calon;
            $walisantri->ik_pghsln_rt = $this->record->ik_pghsln_rt_calon;
            $walisantri->ik_ustadz_kajian = $this->record->ik_ustadz_kajian_calon;
            $walisantri->ik_tempat_kajian = $this->record->ik_tempat_kajian_calon;
            $walisantri->w_status = $this->record->w_status_calon;
            $walisantri->w_hubungan = $this->record->w_hubungan_calon;
            $walisantri->w_nama_lengkap = $this->record->w_nama_lengkap_calon;
            $walisantri->w_nama_kunyah = $this->record->w_nama_kunyah_calon;
            $walisantri->w_pekerjaan_utama = $this->record->w_pekerjaan_utama_calon;
            $walisantri->w_pghsln_rt = $this->record->w_pghsln_rt_calon;
            $walisantri->w_ustadz_kajian = $this->record->w_ustadz_kajian_calon;
            $walisantri->w_tempat_kajian = $this->record->w_tempat_kajian_calon;

            $walisantri->save();

            // $this->dispatch('walisantricreated', $walisantri->id);

            // $userid = User::where('username', $this->record->kk_calon)->get('id');

            // $walisantri_id = Walisantri::where('user_id', $userid)->get('id');


            // $santri = new santri;

            // $santri->walisantri_id = $walisantri_id;
            // $santri->save();

        } else {
            return;
        }
    }

    // #[On('walisantricreated')]
    // public function createSantri($id)
    // {

    //     $now = new DateTime();
    //     $year = $now->format("Y");

    //     $getnism = NismPerTahun::where('tahun', $year)->get('nismstart');
    //     $nism = Str::substr($getnism, 15, 6);

    //     if (
    //         Santri::where('nik', $this->record->nik_calon)
    //         ->where(function ($query) {
    //             return $query
    //                 ->where('nism', NismPerTahun::where('tahun', '2024')->get('nismstart'))->count() === 0;
    //         })
    //         ->count() === 0
    //     ) {

    //         $santri = new santri;

    //         $santri->walisantri_id = $id;
    //         $santri->nism = $nism;
    //         $santri->save();
    //     } elseif (
    //         Santri::where('nik', $this->record->nik_calon)
    //         ->where(function ($query) {
    //             return $query
    //                 ->where('nism', NismPerTahun::where('tahun', '2024')->get('nismstart'))->count() === 1;
    //         })
    //         ->count() === 0
    //     ) {

    //         $santri = new santri;

    //         $santri->walisantri_id = $id;
    //         $santri->nism = '240001';
    //         $santri->save();
    //     }else{
    //         return;
    //     }
    // }

    // protected function getRedirectUrl(): string
    // {
    //     return $this->getResource()::getUrl('index');
    // }

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            // Actions\DeleteAction::make(),
        ];
    }
}
