<?php

namespace Database\Seeders;

use App\Models\Section;
use App\Models\AcademicClass;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $academic_classes = AcademicClass::get();

        $classes = [];

        foreach($academic_classes as $academic_class){
            $classes[] = [
                'name' => 'Section A',
                'academic_class_id' => $academic_class->id,
                'teacher_id' => 1
            ];
            $classes[] = [
                'name' => 'Section B',
                'academic_class_id' => $academic_class->id,
                'teacher_id' => 1
            ];
            $classes[] = [
                'name' => 'Section C',
                'academic_class_id' => $academic_class->id,
                'teacher_id' => 1
            ];
            $classes[] = [
                'name' => 'Section D',
                'academic_class_id' => $academic_class->id,
                'teacher_id' => 1
            ];
            $classes[] = [
                'name' => 'Section E',
                'academic_class_id' => $academic_class->id,
                'teacher_id' => 1
            ];
        }

        Section::insert($classes);
        // Section::create([
        //     'name' => 'Section A',
        //     'academic_class_id' => 1,
        //     'teacher_id' => 1,

        // ]);

        // Section::create([
        //     'name' => 'Section B',
        //     'academic_class_id' => 1,
        //     'teacher_id' => 2,

        // ]);

        // Section::create([
        //     'name' => 'Section A',
        //     'academic_class_id' => 2,
        //     'teacher_id' => 1,

        // ]);

        // Section::create([
        //     'name' => 'Section B',
        //     'academic_class_id' => 2,
        //     'teacher_id' => 2,

        // ]);

        // Section::create([
        //     'name' => 'Section C',
        //     'academic_class_id' => 2,
        //     'teacher_id' => 2,

        // ]);

        // Section::create([
        //     'name' => 'Section D',
        //     'academic_class_id' => 2,
        //     'teacher_id' => 1,

        // ]);

        // Section::create([
        //     'name' => 'Section E',
        //     'academic_class_id' => 2,
        //     'teacher_id' => 2,

        // ]);
    }
}
