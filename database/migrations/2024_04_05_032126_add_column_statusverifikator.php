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
            $table->boolean('status_verifikator')->after('status')->default(false);
        });
        Schema::table('libraries', function (Blueprint $table) {
            $table->boolean('status_verifikator')->after('status')->default(false);
        });
        Schema::table('bukti_fisiks', function (Blueprint $table) {
            $table->boolean('status_verifikator')->after('status')->default(false);
        });   
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sub_komponens', function (Blueprint $table) {
            $table->dropColumn('status_verifikator');
        });

        Schema::table('libraries', function (Blueprint $table) {
            $table->dropColumn('status_verifikator');
        });

        Schema::table('bukti_fisiks', function (Blueprint $table) {
            $table->dropColumn('status_verifikator');
        });
    }
};
