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
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('timetable_id')->constrained('time_tables')->onDelete('cascade');
            $table->string('attendee_id');
            $table->string('attendee_type');
            $table->enum('status', ['present', 'absent', 'late'])->default('present');
            $table->date('date');
            $table->string('previous_hash');
            $table->string('hash');
            $table->text('remarks')->nullable();
            $table->timestamps();

            $table->softDeletes();
            $table->index(['attendee_id', 'attendee_type']);
            $table->index(['timetable_id','attendee_id', 'attendee_type']);

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendances');
    }
};
