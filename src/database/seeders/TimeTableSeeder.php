<?php

namespace Database\Seeders;

use App\Models\TimeTable;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TimeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TimeTable::create([
            'academic_year_id' => 1,
            'academic_class_id' => 1,
            'section_id' => 1,
            'subject_id' => 1,
            'teacher_id' => 1,
            'date' => '2025-02-17',
            'day' => 'Monday',
            'start_time' => '09:00',
            'end_time' => '10:30',
            'type' => 'Lecture'
        ]);
    }
}
