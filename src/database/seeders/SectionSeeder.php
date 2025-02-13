<?php

namespace Database\Seeders;

use App\Models\Section;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Section::create([
            'name' => 'Section A',
            'academic_class_id' => 1,
            'teacher_id' => 1,

        ]);

        Section::create([
            'name' => 'Section B',
            'academic_class_id' => 1,
            'teacher_id' => 2,

        ]);

        Section::create([
            'name' => 'Section A',
            'academic_class_id' => 2,
            'teacher_id' => 1,

        ]);

        Section::create([
            'name' => 'Section B',
            'academic_class_id' => 2,
            'teacher_id' => 2,

        ]);

        Section::create([
            'name' => 'Section C',
            'academic_class_id' => 2,
            'teacher_id' => 2,

        ]);

        Section::create([
            'name' => 'Section D',
            'academic_class_id' => 2,
            'teacher_id' => 1,

        ]);

        Section::create([
            'name' => 'Section E',
            'academic_class_id' => 2,
            'teacher_id' => 2,

        ]);
    }
}
