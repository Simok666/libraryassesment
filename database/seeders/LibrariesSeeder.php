<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LibrariesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = \Faker\Factory::create();

        for ($i = 1; $i <= 20; $i++) {
            \Illuminate\Support\Facades\DB::table('libraries')->insert([
                'user_id' => $faker->numberBetween(1, 10),
                'nomor_npp' => $faker->numerify('#######'),
                'hasil_akreditasi' => $faker->randomElement(['A', 'B', 'C', 'Belum akreditasi']),
                'nama_perpustakaan' => $faker->company,
                'alamat' => $faker->address,
                'desa' => $faker->city,
                'kabupaten_kota' => $faker->city,
                'provinsi' => $faker->state,
                'no_telp' => $faker->phoneNumber,
                'situs_web' => $faker->url,
                'email' => $faker->email,
                'status_kelembagaan' => $faker->randomElement(['Negeri', 'Swasta']),
                'tahun_berdiri_perpustakaan' => $faker->year,
                'sk_pendirian_perpustakaan' => $faker->numerify('####/KEP.##/III/##'),
                'nama_kepala_perpustakaan' => $faker->name,
                'nama_kepala_instansi' => $faker->name,
                'induk' => $faker->boolean(),
                'visi' => $faker->realText(100),
                'misi' => $faker->realText(200),
            ]);
        }

    }
}
