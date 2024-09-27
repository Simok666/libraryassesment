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
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedBigInteger('id_satuan_kerja_eselon_3');
            $table->unsignedBigInteger('id_satuan_kerja_eselon_2');
            $table->unsignedBigInteger('id_satuan_kerja_eselon_1');
            $table->unsignedBigInteger('id_fungsi');

            $table->foreign('id_satuan_kerja_eselon_1')->references('id')->on('eselon_satus')->onDelete('cascade');
            $table->foreign('id_satuan_kerja_eselon_2')->references('id')->on('eselon_duas')->onDelete('cascade');
            $table->foreign('id_satuan_kerja_eselon_3')->references('id')->on('eselon_tigas')->onDelete('cascade');
            $table->foreign('id_fungsi')->references('id')->on('fungsis')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('id_satuan_kerja_eselon_3');
            $table->dropColumn('id_satuan_kerja_eselon_2');
            $table->dropColumn('id_satuan_kerja_eselon_1');
            $table->dropColumn('id_fungsi');
        });
    }
};
