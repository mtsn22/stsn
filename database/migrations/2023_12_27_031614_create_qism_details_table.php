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
        Schema::create('qism_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('qism_id');
            $table->string('abbr_qism_detail');
            $table->string('qism_detail');
            $table->timestamps();

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
        Schema::dropIfExists('qism_details');
    }
};
