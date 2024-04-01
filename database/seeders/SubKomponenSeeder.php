<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use DB;

class SubKomponenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        $userCounter = 1;

        for ($subkomponenId = 1; $subkomponenId <= 20; $subkomponenId++) {
            
            $subkomponenIdInRange = ($subkomponenId % 9 == 0) ? 9 : $subkomponenId % 9;
            
            $userId = ceil($subkomponenId / 9);

            DB::table('sub_komponens')->insert([
                'subkomponen_id' => $subkomponenIdInRange,
                'user_id' => $userId,
                'skor_subkomponen' => $faker->numberBetween(1, 100),
                'nilai' => $faker->numberBetween(1, 100)
            ]);
        }
    }
}
