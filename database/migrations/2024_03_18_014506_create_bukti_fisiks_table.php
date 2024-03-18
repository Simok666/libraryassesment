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
        Schema::create('bukti_fisiks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('bukti_fisik_data_id');
            $table->enum('status',['Baru', 'Aktif', 'Selesai']);
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('bukti_fisik_data_id')->references('id')->on('bukti_fisik_data');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bukti_fisiks');
    }
};
