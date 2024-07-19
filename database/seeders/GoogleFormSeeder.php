<?php

namespace Database\Seeders;

use App\Models\GoogleForm;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
class GoogleFormSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        GoogleForm::create([
            'title' => 'link',
            'link' => 'example.com'
        ]);
    }
}
