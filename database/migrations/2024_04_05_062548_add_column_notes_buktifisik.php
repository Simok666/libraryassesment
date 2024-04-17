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
        Schema::table('bukti_fisiks', function (Blueprint $table) {
            $table->text('notes')->after('status_verifikator')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bukti_fisiks', function (Blueprint $table) {
            $table->dropColumn('notes');
        });
    }
};
