<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;

class BuktiFisikDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('bukti_fisik_data')->insert([
            [
                'title_bukti_fisik' => 'Komponen Koleksi Perpustakaan',
            ],
            [
                'title_bukti_fisik' => 'Komponen Sarana dan Prasarana Perpustakaan',
            ],
            [
                'title_bukti_fisik' => 'Komponen Pelayanan Perpustakaan',
            ],
            [
                'title_bukti_fisik' => 'Komponen Tenaga Perpustakaan',
            ],
            [
                'title_bukti_fisik' => 'Komponen Penyelenggaraan Perpustakaan',
            ],
            [
                'title_bukti_fisik' => 'Komponen Pengelolaan Perpustakaan',
            ],
            [
                'title_bukti_fisik' => 'Komponen Inovasi dan Kreativitas',
            ],
            [
                'title_bukti_fisik' => 'Komponen Tingkat Kegemaran Membaca',
            ],
            [
                'title_bukti_fisik' => 'Komponen Indeks Pembangunan Literasi Masyarakat',
            ],
            
        ]);
    }
}
