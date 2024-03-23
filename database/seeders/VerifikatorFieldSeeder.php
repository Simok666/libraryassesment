<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\VerifikatorField;
use Illuminate\Support\Facades\Hash;

class VerifikatorFieldSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        VerifikatorField::create([
            'name' => 'Demo verifikator field',
            'email' => 'simokart3@gmail.com',
            'password' => Hash::make('12345678')
        ]);
    }
}
