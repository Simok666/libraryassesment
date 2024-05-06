<?php

namespace Database\Seeders;

use App\Models\Grading;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;

class GradingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('gradings')->insert([
            [
                'grade' => 'A',
                'details' => 'Akreditasi A (Baik Sekali) skor 91-100.',
            ],
            [
                'grade' => 'B',
                'details' => 'Akreditasi B (Baik) skor 76-90.',
            ],
            [
                'grade' => 'C',
                'details' => 'Akreditasi C (Cukup Baik) skor 60-75.',
            ],
            [
                'grade' => 'D',
                'details' => 'Tidak Terakreditasi, bila jumlah skor kurang dari 60',
            ],
        ]);
    }
}
