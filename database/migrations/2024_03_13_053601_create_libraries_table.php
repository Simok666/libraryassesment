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
        Schema::create('libraries', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->text('nomor_npp');
            $table->text('hasil_akreditasi');
            $table->string('nama_perpustakaan');
            $table->text('alamat');
            $table->text('desa');
            $table->text('kabupaten_kota');
            $table->text('provinsi');
            $table->text('no_telp');
            $table->text('situs_web');
            $table->text('email');
            $table->enum('status_kelembagaan',['Negeri', 'Swasta']);
            $table->text('tahun_berdiri_perpustakaan');
            $table->text('sk_pendirian_perpustakaan');
            $table->text('nama_kepala_perpustakaan');
            $table->text('nama_kepala_instansi');
            $table->text('induk');
            $table->enum('jenis_perpustakaan',['Perpustakaan Khusus', 'Perpustakaan Perguruan Tinggi']);
            $table->text('visi');
            $table->text('misi');
            $table->enum('status',['Baru', 'Aktif', 'Selesai']);
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('libraries');
    }
};
