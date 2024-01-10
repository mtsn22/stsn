<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('santris', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('orangtua_id');
            $table->string('nism')->unique();
            $table->string('nama_lengkap');
            $table->string('nama_panggilan')->nullable();
            $table->string('nisn')->nullable();
            $table->boolean('belum_punya_nism')->nullable();
            $table->string('kewarganegaraan')->nullable();
            $table->string('asal_negara')->nullable();
            $table->string('kitas')->nullable();
            $table
                ->string('nik')
                ->nullable()
                ->unique();
            $table->boolean('belum_punya_nik')->nullable();
            $table->string('jenikelamin')->nullable();
            $table->string('tempat_lahir')->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->string('agama')->nullable();
            $table->string('cita_cita')->nullable();
            $table->string('cita_cita_lainnya')->nullable();
            $table->string('anak_ke')->nullable();
            $table->string('jumlah_saudara')->nullable();
            $table->boolean('tdk_hp')->nullable();
            $table->string('nomor_handphone')->nullable();
            $table->string('email')->nullable();
            $table->string('hobi')->nullable();
            $table->string('aktivitapend')->nullable();
            $table->string('bya_sklh')->nullable();
            $table->string('kebutuhan_khusus')->nullable();
            $table->string('keb_dis')->nullable();
            $table->string('nomor_kip')->nullable();
            $table->string('kartu_keluarga')->nullable();
            $table->string('nama_kpl_kel')->nullable();
            $table->string('file_kip')->nullable();
            $table->string('al_s_status_mukim')->nullable();
            $table->string('al_s_stts_tptgl')->nullable();
            $table->string('al_s_stts_rmh')->nullable();
            $table->unsignedBigInteger('provinsi_id');
            $table->unsignedBigInteger('kabupaten_id');
            $table->unsignedBigInteger('kecamatan_id');
            $table->unsignedBigInteger('kelurahan_id');
            $table->string('al_s_rt');
            $table->string('al_s_rw');
            $table->text('al_s_alamat');
            $table->unsignedBigInteger('kodepos_id');
            $table->string('al_s_jarak');
            $table->string('al_s_transportasi');
            $table->string('al_s_waktu_tempuh');
            $table->string('al_s_koordinat');
            $table->timestamps();

            $table
                ->foreign('orangtua_id')
                ->references('id')
                ->on('orangtuas')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');

            $table
                ->foreign('provinsi_id')
                ->references('id')
                ->on('provinsis')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');

            $table
                ->foreign('kabupaten_id')
                ->references('id')
                ->on('kabupatens')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');

            $table
                ->foreign('kecamatan_id')
                ->references('id')
                ->on('kecamatans')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');

            $table
                ->foreign('kelurahan_id')
                ->references('id')
                ->on('kelurahans')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');

            $table
                ->foreign('kodepos_id')
                ->references('id')
                ->on('kodepos')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('santris');
    }
};
