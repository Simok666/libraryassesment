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
        Schema::create('fungsis', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_eselon_tiga');
            $table->text('nama_fungsi');
            $table->timestamps();

            $table->foreign('id_eselon_tiga')->references('id')->on('eselon_tigas');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fungsis');
    }
};
