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
        Schema::create('sections', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('teacher_id');
            $table->string('academic_year_id')->constrained('academic_years')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
            //Adding composite unique constraint on name and academic_year_id
            $table->index(['name','academic_year_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sections');
    }
};
