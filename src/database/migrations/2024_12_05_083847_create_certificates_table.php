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
        Schema::create('certificates', function (Blueprint $table) {
            $table->id();
            $table->string('student_id');
            $table->string('certificate_type');
            $table->date('issue_date');
            $table->date('expiry_date')->nullable();
            $table->string('issued_by');
            $table->string('academic_year_id')->constrained('academic_years')->onDelete('cascade');
            $table->text('additional_details')->nullable();
            $table->json('grade_details');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('certificates');
    }
};
