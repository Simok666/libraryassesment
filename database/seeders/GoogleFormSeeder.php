<?php

namespace Database\Seeders;

use App\Models\GoogleForm;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use DB;
class GoogleFormSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('google_forms')->insert([
            [
                'title' => 'link-1',
                'link' => 'link-1.com',
            ],
            [
                'title' => 'link-2',
                'link' => 'link-2.com',
            ],
            [
                'title' => 'link-3',
                'link' => 'link-3.com',
            ],
        ]);
    }
}
