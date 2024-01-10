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
        Schema::create('orangtuas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('kartu_keluarga')->unique();
            $table->string('ak_nama_lengkap');
            $table->string('ak_status')->nullable();
            $table->string('ak_kewarganegaraan')->nullable();
            $table->string('ak_asal_negara')->nullable();
            $table->string('ak_kitas')->nullable();
            $table
                ->string('ak_nik')
                ->nullable()
                ->unique();
            $table->string('ak_tempat_lahir')->nullable();
            $table->string('ak_tanggal_lahir')->nullable();
            $table->string('ak_pend_terakhir')->nullable();
            $table->string('ak_pekerjaan_utama')->nullable();
            $table->string('ak_pghsln_rt')->nullable();
            $table->boolean('ak_tdk_hp')->nullable();
            $table->string('ak_nomor_handphone')->nullable();
            $table->string('file_kk')->nullable();
            $table->string('ik_nama_lengkap')->nullable();
            $table->string('ik_status')->nullable();
            $table->string('ik_kewarganegaraan')->nullable();
            $table->string('ik_asal_negara')->nullable();
            $table->string('ik_kitas')->nullable();
            $table->string('ik_nik')->nullable();
            $table->string('ik_tempat_lahir')->nullable();
            $table->date('ik_tanggal_lahir')->nullable();
            $table->string('ik_pend_terakhir')->nullable();
            $table->string('ik_pekerjaan_utama')->nullable();
            $table->string('ik_pghsln_rt')->nullable();
            $table->boolean('ik_tdk_hp')->nullable();
            $table->string('ik_nomor_handphone')->nullable();
            $table->boolean('ik_kk_sama_ak')->nullable();
            $table->string('w_status')->nullable();
            $table->string('w_nama_lengkap')->nullable();
            $table->string('w_kewarganegaraan')->nullable();
            $table->string('w_asal_negara')->nullable();
            $table->string('w_kitas')->nullable();
            $table->string('w_nik')->nullable();
            $table->string('w_tempat_lahir')->nullable();
            $table->date('w_tanggal_lahir')->nullable();
            $table->string('w_pend_terakhir')->nullable();
            $table->string('w_pekerjaan_utama')->nullable();
            $table->string('w_pghsln_rt')->nullable();
            $table->boolean('w_tdk_hp')->nullable();
            $table->string('w_nomor_handphone')->nullable();
            $table->boolean('al_ak_tgldi_ln');
            $table->text('al_ak_almt_ln');
            $table->string('al_ak_stts_rmh');
            $table->unsignedBigInteger('al_ak_provinsi_id');
            $table->unsignedBigInteger('al_ak_kabupaten_id');
            $table->unsignedBigInteger('al_ak_kecamatan_id');
            $table->unsignedBigInteger('al_ak_kelurahan_id');
            $table->string('al_ak_rt');
            $table->string('al_ak_rw');
            $table->string('al_ak_alamat');
            $table->unsignedBigInteger('al_ak_kodepos_id');
            $table->boolean('al_ik_sama_ak');
            $table->boolean('al_ik_tgldi_ln');
            $table->text('al_ik_almt_ln');
            $table->string('al_ik_stts_rmh');
            $table->unsignedBigInteger('al_ik_provinsi_id');
            $table->unsignedBigInteger('al_ik_kabupaten_id');
            $table->unsignedBigInteger('al_ik_kecamatan_id');
            $table->unsignedBigInteger('al_ik_kelurahan_id');
            $table->string('al_ik_rt');
            $table->string('al_ik_rw');
            $table->text('al_ik_alamat');
            $table->unsignedBigInteger('al_ik_kodepos_id');
            $table->string('al_w_dmsl');
            $table->boolean('al_w_tgldi_ln');
            $table->text('al_w_almt_ln');
            $table->string('al_w_stts_rmh');
            $table->unsignedBigInteger('al_w_provinsi_id');
            $table->unsignedBigInteger('al_w_kabupaten_id');
            $table->unsignedBigInteger('al_w_kecamatan_id');
            $table->unsignedBigInteger('al_w_kelurahan_id');
            $table->string('al_w_rt');
            $table->string('al_w_rw');
            $table->text('al_w_alamat');
            $table->unsignedBigInteger('al_w_kodepos_id');
            $table->timestamps();

            $table
                ->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');

            $table
                ->foreign('al_ak_provinsi_id')
                ->references('id')
                ->on('provinsis')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');

            $table
                ->foreign('al_ak_kabupaten_id')
                ->references('id')
                ->on('kabupatens')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');

            $table
                ->foreign('al_ak_kecamatan_id')
                ->references('id')
                ->on('kecamatans')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');

            $table
                ->foreign('al_ak_kelurahan_id')
                ->references('id')
                ->on('kelurahans')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');

            $table
                ->foreign('al_ak_kodepos_id')
                ->references('id')
                ->on('kodepos')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');

            $table
                ->foreign('al_ik_provinsi_id')
                ->references('id')
                ->on('provinsis')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');

            $table
                ->foreign('al_ik_kabupaten_id')
                ->references('id')
                ->on('kabupatens')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');

            $table
                ->foreign('al_ik_kecamatan_id')
                ->references('id')
                ->on('kecamatans')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');

            $table
                ->foreign('al_ik_kelurahan_id')
                ->references('id')
                ->on('kelurahans')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');

            $table
                ->foreign('al_ik_kodepos_id')
                ->references('id')
                ->on('kodepos')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');

            $table
                ->foreign('al_w_provinsi_id')
                ->references('id')
                ->on('provinsis')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');

            $table
                ->foreign('al_w_kabupaten_id')
                ->references('id')
                ->on('kabupatens')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');

            $table
                ->foreign('al_w_kecamatan_id')
                ->references('id')
                ->on('kecamatans')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');

            $table
                ->foreign('al_w_kelurahan_id')
                ->references('id')
                ->on('kelurahans')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');

            $table
                ->foreign('al_w_kodepos_id')
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
        Schema::dropIfExists('orangtuas');
    }
};
