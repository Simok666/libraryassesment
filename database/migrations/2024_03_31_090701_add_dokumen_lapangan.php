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
        Schema::table('sub_komponens', function (Blueprint $table) {
            $table->text('verifikasi_lapangan')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sub_komponens', function (Blueprint $table) {
            $table->dropColumn('verifikasi_lapangan');
        });
    }
};
