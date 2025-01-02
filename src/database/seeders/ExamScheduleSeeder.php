<?php

namespace Database\Seeders;

use App\Models\ExamSchedule;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ExamScheduleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ExamSchedule::create([
            'exam_id' => 1,
            'section_id' => 1,
            'subject' => 'M-101',
            'date'=> '2024-10-08',
            'start_time' => '09:00',
            'end_time' => '12:00'
        ]);
    }
}
