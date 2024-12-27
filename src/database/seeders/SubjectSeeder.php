<?php

namespace Database\Seeders;

use App\Models\Subject;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SubjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Subject::create([
            'name' => 'Math',
            'code' => 'M-101',
            'description' => 'Mathematic of Grade 10'
        ]);

        Subject::create([
            'name' => 'English',
            'code' => 'E-101',
            'description' => 'English of Grade 10'
        ]);
    }
}
