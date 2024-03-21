<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\VerifikatorDesk;
use Illuminate\Support\Facades\Hash;

class VerifikatorDeskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        VerifikatorDesk::create([
            'name' => 'Demo verifikator desk',
            'email' => 'simokart3@gmail.com',
            'password' => Hash::make('12345678')
        ]);
    }
}
