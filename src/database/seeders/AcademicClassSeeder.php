<?php

namespace Database\Seeders;

use App\Models\AcademicClass;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AcademicClassSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        AcademicClass::create([
            'name' => 'Primary 1',
            'academic_year_id' => 1,
        ]);

        AcademicClass::create([
            'name' => 'Primary 2',
            'academic_year_id' => 1,
        ]);

        AcademicClass::create([
            'name' => 'Primary 1',
            'academic_year_id' => 2,
        ]);

        AcademicClass::create([
            'name' => 'Primary 2',
            'academic_year_id' => 2,
        ]);

        AcademicClass::create([
            'name' => 'Primary 3',
            'academic_year_id' => 1,
        ]);

        AcademicClass::create([
            'name' => 'Primary 3',
            'academic_year_id' => 1,
        ]);

        AcademicClass::create([
            'name' => 'Primary 4',
            'academic_year_id' => 2,
        ]);

        AcademicClass::create([
            'name' => 'Primary 4',
            'academic_year_id' => 2,
        ]);

        AcademicClass::create([
            'name' => 'Primary 5',
            'academic_year_id' => 1,
        ]);

        AcademicClass::create([
            'name' => 'Primary 5',
            'academic_year_id' => 1,
        ]);

        AcademicClass::create([
            'name' => 'Primary 6',
            'academic_year_id' => 2,
        ]);

        AcademicClass::create([
            'name' => 'Primary 6',
            'academic_year_id' => 2,
        ]);

        AcademicClass::create([
            'name' => 'Primary 7',
            'academic_year_id' => 1,
        ]);

        AcademicClass::create([
            'name' => 'Primary 7',
            'academic_year_id' => 1,
        ]);

        AcademicClass::create([
            'name' => 'Primary 8',
            'academic_year_id' => 2,
        ]);

        AcademicClass::create([
            'name' => 'Primary 8',
            'academic_year_id' => 2,
        ]);

        AcademicClass::create([
            'name' => 'Primary 9',
            'academic_year_id' => 1,
        ]);

        AcademicClass::create([
            'name' => 'Primary 9',
            'academic_year_id' => 1,
        ]);

        AcademicClass::create([
            'name' => 'Primary 10',
            'academic_year_id' => 2,
        ]);

        AcademicClass::create([
            'name' => 'Primary 10',
            'academic_year_id' => 2,
        ]);
    }
}
