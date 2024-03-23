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
        Schema::create('sub_komponens', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('subkomponen_id');
            $table->unsignedBigInteger('user_id');
            $table->integer('skor_subkomponen');
            $table->integer('nilai');
            $table->boolean('is_verified')->default(false);
            $table->enum('status',['Baru', 'Aktif', 'Selesai']);
            $table->text('notes')->nullable();
            $table->enum('status_verifikator',['Sesuai', 'Belum Sesuai'])->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('subkomponen_id')->references('id')->on('komponens');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sub_komponens');
    }
};
