<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('time_tables', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->string('academic_class_id')->nullable();
            $table->string('section_id')->nullable();
            $table->string('subject_id')->nullable();
            $table->string('teacher_id')->nullable();
            $table->string('room')->nullable();
            $table->date('date')->nullable();
            $table->time('start_time')->nullable();
            $table->time('end_time')->nullable();
            $table->enum('type',['Class', 'Extra', 'Free', 'Holiday','Lecture', 'Lab', 'Tutorial', 'Seminar', 'Self-Study','Break-Time'])->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('time_tables');
    }
};
