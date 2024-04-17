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
            $table->boolean('status_perpustakaan')->after('is_verified')->default(false);
            $table->boolean('status_subkomponent')->after('status_perpustakaan')->default(false);
            $table->boolean('status_buktifisik')->after('status_subkomponent')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('status_perpustakaan');
            $table->dropColumn('status_subkomponent');
            $table->dropColumn('status_buktifisik');
        });
    }
};
