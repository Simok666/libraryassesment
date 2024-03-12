<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Pimpinan;
use Illuminate\Support\Facades\Hash;

class PimpinanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Pimpinan::create([
            'name' => 'Demo Admin',
            'email' => 'simokart3@gmail.com',
            'password' => Hash::make('12345678')
        ]);
    }
}
