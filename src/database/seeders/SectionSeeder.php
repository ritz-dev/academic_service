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
            'name' => 'A',
            'academic_class_id' => 1,
            'teacher_id' => 1,
            // 'academic_year_id' => 1,
        ]);

        Section::create([
            'name' => 'B',
            'academic_class_id' => 1,
            'teacher_id' => 2,
            // 'academic_year_id' => 1,
        ]);

        Section::create([
            'name' => 'A',
            'academic_class_id' => 2,
            'teacher_id' => 1,
            // 'academic_year_id' => 1,
        ]);

        Section::create([
            'name' => 'B',
            'academic_class_id' => 2,
            'teacher_id' => 2,
            // 'academic_year_id' => 1,
        ]);

        Section::create([
            'name' => 'C',
            'academic_class_id' => 2,
            'teacher_id' => 2,
            // 'academic_year_id' => 1,
        ]);
    }
}
