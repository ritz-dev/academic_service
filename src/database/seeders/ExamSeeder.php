<?php

namespace Database\Seeders;

use App\Models\Exam;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ExamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Exam::create([
            'name' => 'Grade-10 Term1',
            'start_date' => '8-10-2024',
            'end_date' => '13-10-2024',
            'grade_id' => 1,
            'academic_year_id' => 1
        ]);
    }
}
