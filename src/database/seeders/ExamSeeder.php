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
            'start_date' => '2024-10-08',
            'end_date' => '2024-10-13',
            'grade_id' => 1,
            'academic_year_id' => 1
        ]);
    }
}
