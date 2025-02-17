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
            'academic_class_id' => 1,
            'section_id' => 1,
            'subject_id' => 1,
            'teacher_id' => 1,
            'room' => 'Room One',
            'date' => '2025-02-17',
            'day' => 'Monday',
            'start_time' => '09:00',
            'end_time' => '10:30',
            'type' => 'Lecture'
        ]);

        TimeTable::create([
            'academic_class_id' => 1,
            'section_id' => 2,
            'subject_id' => 1,
            'teacher_id' => 1,
            'room' => 'Room Two',
            'date' => '2025-02-18',
            'day' => 'Monday',
            'start_time' => '09:00',
            'end_time' => '10:30',
            'type' => 'Lecture'
        ]);

        TimeTable::create([
            'academic_class_id' => 1,
            'section_id' => 3,
            'subject_id' => 1,
            'teacher_id' => 1,
            'room' => 'Room Three',
            'date' => '2025-02-19',
            'day' => 'Monday',
            'start_time' => '09:00',
            'end_time' => '10:30',
            'type' => 'Lecture'
        ]);

        TimeTable::create([
            'academic_class_id' => 1,
            'section_id' => 1,
            'subject_id' => 1,
            'teacher_id' => 1,
            'room' => 'Room One',
            'date' => '2025-02-17',
            'day' => 'Monday',
            'start_time' => '10:30',
            'end_time' => '12:00',
            'type' => 'Lecture'
        ]);

        TimeTable::create([
            'academic_class_id' => 1,
            'section_id' => 1,
            'subject_id' => 1,
            'teacher_id' => 1,
            'room' => 'Room One',
            'date' => '2025-02-17',
            'day' => 'Monday',
            'start_time' => '12:00',
            'end_time' => '01:00',
            'type' => 'Break-Time'
        ]);
    }
}
