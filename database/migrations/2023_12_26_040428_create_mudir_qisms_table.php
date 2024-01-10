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
        Schema::create('mudir_qisms', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pengajar_id');
            $table->unsignedBigInteger('qism_id');
            $table->timestamps();

            $table
                ->foreign('pengajar_id')
                ->references('id')
                ->on('pengajars')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');

            $table
                ->foreign('qism_id')
                ->references('id')
                ->on('qisms')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mudir_qisms');
    }
};
