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
            'name' => 'primary 1',
            'academic_year_id' => 1,
        ]);

        AcademicClass::create([
            'name' => 'primary 2',
            'academic_year_id' => 1,
        ]);
    }
}
