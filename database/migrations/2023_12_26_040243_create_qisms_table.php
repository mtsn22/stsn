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
        Schema::create('qisms', function (Blueprint $table) {
            $table->id();
            $table
                ->string('qism')
                ->nullable()
                ->unique();
            $table
                ->string('kode_qism')
                ->nullable()
                ->unique();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('qisms');
    }
};
