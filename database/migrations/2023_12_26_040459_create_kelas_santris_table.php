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
        Schema::create('kelas_santris', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('mahad_id');
            $table->unsignedBigInteger('qism_id');
            $table->unsignedBigInteger('tahun_ajaran_id');
            $table->unsignedBigInteger('semester_id');
            $table->unsignedBigInteger('kelas_id');
            $table->unsignedBigInteger('santri_id');
            $table->date('tanggalupdate');
            $table->boolean('is_active');
            $table->timestamps();

            $table
                ->foreign('mahad_id')
                ->references('id')
                ->on('mahads')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');

            $table
                ->foreign('qism_id')
                ->references('id')
                ->on('qisms')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');

            $table
                ->foreign('tahun_ajaran_id')
                ->references('id')
                ->on('tahun_ajarans')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');

            $table
                ->foreign('semester_id')
                ->references('id')
                ->on('semesters')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');

            $table
                ->foreign('kelas_id')
                ->references('id')
                ->on('kelas')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');

            $table
                ->foreign('santri_id')
                ->references('id')
                ->on('santris')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kelas_santris');
    }
};
