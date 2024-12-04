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
            'class_id' => 1,
            'subject_id' => 1,
            'teacher_id' => 1,
            'day_of_week' => 'Monday',
            'time_start' => '09:00',
            'time_end' => '10:30',
            'term' => 'term 1'
        ]);
    }
}
