<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use DB;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        foreach (range(1, 20) as $index) {
            DB::table('users')->insert([
                'name' => $faker->name,
                'email' => $faker->unique()->safeEmail,
                'password' => bcrypt('password'),
                'instance_name' => Str::random(10),
                'pic_name' => Str::random(10),
                'leader_instance_name' => Str::random(10),
                'library_name' => Str::random(10),
                'head_library_name' => Str::random(10),
                'npp' => Str::random(10),
                'address' => Str::random(10),
                'map_coordinates' => Str::random(10),
                'village' => Str::random(10),
                'subdistrict' => Str::random(10),
                'city' => Str::random(10),
                'province' => Str::random(10),
                'number_telephone' => Str::random(10),
                'website' => Str::random(10),
                'library_email' => Str::random(10),
                'is_verified' => 1,
            ]);
        }
    }
}
