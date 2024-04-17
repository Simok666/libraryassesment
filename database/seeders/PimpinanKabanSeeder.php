<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\PimpinanKaban;
use Illuminate\Support\Facades\Hash;

class PimpinanKabanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PimpinanKaban::create([
            'name' => 'Demo Pimpinan Kaban',
            'email' => 'simokart3@gmail.com',
            'password' => Hash::make('12345678')
        ]);
    }
}
