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

        // Define time slots
        $time_slots = [
            ['start' => '9:00', 'end' => '10:30'],
            ['start' => '10:30', 'end' => '12:00'],
            ['start' => '12:00', 'end' => '13:00'], // Break-Time
            ['start' => '13:00', 'end' => '14:30']
        ];

        // Define holidays
        $holidays = [
            '2025-02-12',
        ];

        while ($startDate->lte($endDate)) {
            if ($startDate->isWeekend() || in_array($startDate->toDateString(), $holidays)) {
                // Insert holiday/weekend record
                TimeTable::create([
                    'academic_class_id' => null,
                    'section_id' => 1,
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
                // Insert 4 sessions per day
                foreach ($time_slots as $slot) {
                    TimeTable::create([
                        'academic_class_id' => ($slot['start'] == '12:00') ? null : 1,
                        'section_id' => ($slot['start'] == '12:00') ? null : 1,
                        'subject_id' => ($slot['start'] == '12:00') ? null : $subjects[array_rand($subjects)],
                        'teacher_id' => ($slot['start'] == '12:00') ? null : $teachers[array_rand($teachers)],
                        'room' => ($slot['start'] == '12:00') ? 'Cafeteria' : $rooms[array_rand($rooms)],
                        'date' => $startDate->toDateString(),
                        'day' => $startDate->format('l'),
                        'start_time' => $slot['start'],
                        'end_time' => $slot['end'],
                        'type' => ($slot['start'] == '12:00') ? 'Break-Time' : 'Lecture'
                    ]);
                }
            }
            // Move to the next day
            $startDate->addDay();


        }

    }
}
