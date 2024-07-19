<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            AdminSeeder::class,
            OperatorSeeder::class,
            PimpinanSeeder::class,
            PimpinanKabanSeeder::class,
            KomponenSeeder::class,
            BuktiFisikDataSeeder::class,
            VerifikatorDeskSeeder::class,
            VerifikatorFieldSeeder::class,
            UserSeeder::class,
            SubKomponenSeeder::class,
            BuktiFisikSeeder::class,
            LibrariesSeeder::class,
            GradingSeeder::class,
            GoogleFormSeeder::class
           ]);
    }
}
