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
        Schema::create('eselon_duas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_eselon_satu');
            $table->text('nama_satuan_kerja_eselon_2');
            $table->timestamps();

            $table->foreign('id_eselon_satu')->references('id')->on('eselon_satus');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('eselon_duas');
    }
};
