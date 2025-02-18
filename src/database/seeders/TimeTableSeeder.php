<?php

namespace Database\Seeders;

use Carbon\Carbon;
use App\Models\TimeTable;
use App\Models\AcademicClass;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TimeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // TimeTable::create([
        //     'academic_class_id' => 1,
        //     'section_id' => 1,
        //     'subject_id' => 1,
        //     'teacher_id' => 1,
        //     'room' => 'Room One',
        //     'date' => '2025-02-17',
        //     'day' => 'Monday',
        //     'start_time' => '09:00',
        //     'end_time' => '10:30',
        //     'type' => 'Lecture'
        // ]);

        // TimeTable::create([
        //     'academic_class_id' => 1,
        //     'section_id' => 2,
        //     'subject_id' => 1,
        //     'teacher_id' => 1,
        //     'room' => 'Room Two',
        //     'date' => '2025-02-18',
        //     'day' => 'Monday',
        //     'start_time' => '09:00',
        //     'end_time' => '10:30',
        //     'type' => 'Lecture'
        // ]);

        // TimeTable::create([
        //     'academic_class_id' => 1,
        //     'section_id' => 3,
        //     'subject_id' => 1,
        //     'teacher_id' => 1,
        //     'room' => 'Room Three',
        //     'date' => '2025-02-19',
        //     'day' => 'Monday',
        //     'start_time' => '09:00',
        //     'end_time' => '10:30',
        //     'type' => 'Lecture'
        // ]);

        // TimeTable::create([
        //     'academic_class_id' => 1,
        //     'section_id' => 1,
        //     'subject_id' => 1,
        //     'teacher_id' => 1,
        //     'room' => 'Room One',
        //     'date' => '2025-02-17',
        //     'day' => 'Monday',
        //     'start_time' => '10:30',
        //     'end_time' => '12:00',
        //     'type' => 'Lecture'
        // ]);

        // TimeTable::create([
        //     'academic_class_id' => 1,
        //     'section_id' => 1,
        //     'subject_id' => 1,
        //     'teacher_id' => 1,
        //     'room' => 'Room One',
        //     'date' => '2025-02-17',
        //     'day' => 'Monday',
        //     'start_time' => '12:00',
        //     'end_time' => '01:00',
        //     'type' => 'Break-Time'
        // ]);

        // TimeTable::create([
        //     'academic_class_id' => 1,
        //     'section_id' => 1,
        //     'subject_id' => 1,
        //     'teacher_id' => 1,
        //     'room' => 'Room One',
        //     'date' => '2025-02-21',
        //     'day' => 'Friday',
        //     'start_time' => '09:00',
        //     'end_time' => '10:30',
        //     'type' => 'Class'
        // ]);

        // TimeTable::create([
        //     'academic_class_id' => 1,
        //     'section_id' => 1,
        //     'subject_id' => 1,
        //     'teacher_id' => 1,
        //     'room' => 'Room One',
        //     'date' => '2025-02-21',
        //     'day' => 'Friday',
        //     'start_time' => '10:30',
        //     'end_time' => '12:00',
        //     'type' => 'Class'
        // ]);

        // TimeTable::create([
        //     'academic_class_id' => 1,
        //     'section_id' => 1,
        //     'subject_id' => 1,
        //     'teacher_id' => 1,
        //     'room' => 'Room One',
        //     'date' => '2025-02-21',
        //     'day' => 'Friday',
        //     'start_time' => '12:00',
        //     'end_time' => '01:00',
        //     'type' => 'Break-Time'
        // ]);

        // TimeTable::create([
        //     'academic_class_id' => 1,
        //     'section_id' => 1,
        //     'subject_id' => 1,
        //     'teacher_id' => 1,
        //     'room' => 'Room One',
        //     'date' => '2025-02-21',
        //     'day' => 'Friday',
        //     'start_time' => '01:00',
        //     'end_time' => '12:30',
        //     'type' => 'Class'
        // ]);


        $startDate = Carbon::parse('2025-02-01'); // Start of the month
        $endDate = Carbon::parse('2025-02-28'); // End of the month

        $subjects = [1, 2, 3, 4]; // Example subject IDs
        $teachers = [1, 2, 3, 4]; // Example teacher IDs
        $rooms = ['Room One', 'Room Two', 'Room Three'];

        // Define holidays
        $holidays = [
            '2025-02-12',
        ];

        while ($startDate->lte($endDate)) {
            if ($startDate->isWeekend() || in_array($startDate->toDateString(), $holidays)) {
                // Insert holiday/weekend record
                TimeTable::create([
                    'academic_class_id' => null,
                    'section_id' => null,
                    'subject_id' => null,
                    'teacher_id' => null,
                    'room' => null,
                    'date' => $startDate->toDateString(),
                    'day' => $startDate->format('l'),
                    'start_time' => null,
                    'end_time' => null,
                    'type' => 'Holiday'
                ]);
            } else {
                // Insert lecture record
                TimeTable::create([
                    'academic_class_id' => 1,
                    'section_id' => 1,
                    'subject_id' => $subjects[array_rand($subjects)],
                    'teacher_id' => $teachers[array_rand($teachers)],
                    'room' => $rooms[array_rand($rooms)],
                    'date' => $startDate->toDateString(),
                    'day' => $startDate->format('l'),
                    'start_time' => '09:00',
                    'end_time' => '10:30',
                    'type' => 'Lecture'
                ]);
            }

            // Move to the next day
            $startDate->addDay();
        }

    }
}
