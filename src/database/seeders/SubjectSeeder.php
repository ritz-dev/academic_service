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

        Subject::create([
            'name' => 'Myanmar',
            'code' => 'My-101',
            'description' => 'Myanmar of Grade 10'
        ]);

        Subject::create([
            'name' => 'Science',
            'code' => 'S-101',
            'description' => 'Science of Grade 10'
        ]);

        Subject::create([
            'name' => 'Geography',
            'code' => 'G-101',
            'description' => 'Geography of Grade 10'
        ]);

        Subject::create([
            'name' => 'History',
            'code' => 'H-101',
            'description' => 'History of Grade 10'
        ]);
    }
}
