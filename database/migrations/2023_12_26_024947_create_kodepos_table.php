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
        Schema::create('kodepos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('kelurahan_id');
            $table->unsignedBigInteger('kecamatan_id');
            $table->unsignedBigInteger('kabupaten_id');
            $table->unsignedBigInteger('provinsi_id');
            $table->string('kodepos');
            $table->timestamps();

            $table
                ->foreign('kelurahan_id')
                ->references('id')
                ->on('kelurahans')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');

            $table
                ->foreign('kecamatan_id')
                ->references('id')
                ->on('kecamatans')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');

            $table
                ->foreign('kabupaten_id')
                ->references('id')
                ->on('kabupatens')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');

            $table
                ->foreign('provinsi_id')
                ->references('id')
                ->on('provinsis')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kodepos');
    }
};
