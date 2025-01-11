<?php

namespace Database\Seeders;

use App\Models\Subject;
use App\Models\AcademicClass;
use Illuminate\Database\Seeder;
use App\Models\AcademicClassSubject;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AcademicClassSubjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $class_id1 = AcademicClass::where('name','primary 1')->pluck('id')->first();

        $class_id2 = AcademicClass::where('name','primary 2')->pluck('id')->first();

        $subject_id1 = Subject::where('name','English')->pluck('id')->first();

        $subject_id2 = Subject::where('name','Myanmar')->pluck('id')->first();

        $subject_id3 = Subject::where('name','Math')->pluck('id')->first();

        AcademicClassSubject::create([
            'academic_class_id' => $class_id1,
            'subject_id' => $subject_id1,
        ]);

        AcademicClassSubject::create([
            'academic_class_id' => $class_id1,
            'subject_id' => $subject_id2,
        ]);

        AcademicClassSubject::create([
            'academic_class_id' => $class_id1,
            'subject_id' => $subject_id3
        ]);

        AcademicClassSubject::create([
            'academic_class_id' => $class_id2,
            'subject_id' => $subject_id1,
        ]);

        AcademicClassSubject::create([
            'academic_class_id' => $class_id2,
            'subject_id' => $subject_id2,
        ]);

        AcademicClassSubject::create([
            'academic_class_id' => $class_id2,
            'subject_id' => $subject_id3
        ]);
    }
}
