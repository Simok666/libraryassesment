<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use DB;

class BuktiFisikSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        $userCounter = 1;

        for ($bukti = 1; $bukti <= 20; $bukti++) {
            
            $buktiFisikIdInRange = ($bukti % 9 == 0) ? 9 : $bukti % 9;
            
            $userId = ceil($bukti / 9);

            DB::table('bukti_fisiks')->insert([
                'user_id' => $userId,
                'bukti_fisik_data_id' => $buktiFisikIdInRange,

            ]);
        }
    }
}
