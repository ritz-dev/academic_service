<?php

namespace Database\Seeders;

use App\Models\ExamTeacherAssignment;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ExamStudentAssignmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ExamTeacherAssignment::create([
            'exam_schedule_id' => 1,
            'student_id' => 1,
        ]);

        ExamTeacherAssignment::create([
            'exam_schedule_id' => 1,
            'student_id' => 2,
        ]);
    }
}
