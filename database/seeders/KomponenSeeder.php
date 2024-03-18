<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Komponen;
use DB;

class KomponenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('komponens')->insert([
            [
                'title_komponens' => 'Koleksi Perpustakaan',
                'jumlah_indikator_kunci' => 14,
                'bobot' => 15,
                'jenis_perpustakaan' => 'Perpustakaan Khusus'
            ],
            [
                'title_komponens' => 'Sarana dan Prasarana Perpustakaan',
                'jumlah_indikator_kunci' => 14,
                'bobot' => 10,
                'jenis_perpustakaan' => 'Perpustakaan Khusus'
            ],
            [
                'title_komponens' => 'Pelayanan Perpustakaan',
                'jumlah_indikator_kunci' => 11,
                'bobot' => 20,
                'jenis_perpustakaan' => 'Perpustakaan Khusus'
            ],
            [
                'title_komponens' => 'Tenaga Perpustakaan',
                'jumlah_indikator_kunci' => 10,
                'bobot' => 15,
                'jenis_perpustakaan' => 'Perpustakaan Khusus'
            ],
            [
                'title_komponens' => 'Penyelenggaraan Perpustakaan',
                'jumlah_indikator_kunci' => 7,
                'bobot' => 10,
                'jenis_perpustakaan' => 'Perpustakaan Khusus'
            ],
            [
                'title_komponens' => 'Pengelolaan Perpustakaan',
                'jumlah_indikator_kunci' => 5,
                'bobot' => 15,
                'jenis_perpustakaan' => 'Perpustakaan Khusus'
            ],
            [
                'title_komponens' => 'Inovasi dan Kreativitas',
                'jumlah_indikator_kunci' => 5,
                'bobot' => 5,
                'jenis_perpustakaan' => 'Perpustakaan Khusus'
            ],
            [
                'title_komponens' => 'Tingkat Kegemaran Membaca',
                'jumlah_indikator_kunci' => 2,
                'bobot' => 5,
                'jenis_perpustakaan' => 'Perpustakaan Khusus'
            ],
            [
                'title_komponens' => 'Indeks Pembangunan Literasi Masyarakat',
                'jumlah_indikator_kunci' => 4,
                'bobot' => 5,
                'jenis_perpustakaan' => 'Perpustakaan Khusus'
            ],
            // perpus pt
            [
                'title_komponens' => 'Koleksi Perpustakaan',
                'jumlah_indikator_kunci' => 18,
                'bobot' => 15,
                'jenis_perpustakaan' => 'Perpustakaan Perguruan Tinggi'
            ],
            [
                'title_komponens' => 'Sarana dan Prasarana Perpustakaan',
                'jumlah_indikator_kunci' => 15,
                'bobot' => 10,
                'jenis_perpustakaan' => 'Perpustakaan Perguruan Tinggi'
            ],
            [
                'title_komponens' => 'Pelayanan Perpustakaan',
                'jumlah_indikator_kunci' => 15,
                'bobot' => 20,
                'jenis_perpustakaan' => 'Perpustakaan Perguruan Tinggi'
            ],
            [
                'title_komponens' => 'Tenaga Perpustakaan',
                'jumlah_indikator_kunci' => 10,
                'bobot' => 15,
                'jenis_perpustakaan' => 'Perpustakaan Perguruan Tinggi'
            ],
            [
                'title_komponens' => 'Penyelenggaraan Perpustakaan',
                'jumlah_indikator_kunci' => 9,
                'bobot' => 10,
                'jenis_perpustakaan' => 'Perpustakaan Perguruan Tinggi'
            ],
            [
                'title_komponens' => 'Pengelolaan Perpustakaan',
                'jumlah_indikator_kunci' => 6,
                'bobot' => 15,
                'jenis_perpustakaan' => 'Perpustakaan Perguruan Tinggi'
            ],
            [
                'title_komponens' => 'Inovasi dan Kreativitas',
                'jumlah_indikator_kunci' => 5,
                'bobot' => 5,
                'jenis_perpustakaan' => 'Perpustakaan Perguruan Tinggi'
            ],
            [
                'title_komponens' => 'Tingkat Kegemaran Membaca',
                'jumlah_indikator_kunci' => 4,
                'bobot' => 5,
                'jenis_perpustakaan' => 'Perpustakaan Perguruan Tinggi'
            ],
            [
                'title_komponens' => 'Indeks Pembangunan Literasi Masyarakat',
                'jumlah_indikator_kunci' => 4,
                'bobot' => 5,
                'jenis_perpustakaan' => 'Perpustakaan Perguruan Tinggi'
            ],
        ]);
    }
}
