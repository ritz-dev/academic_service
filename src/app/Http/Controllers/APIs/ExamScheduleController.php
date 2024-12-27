<?php

namespace App\Http\Controllers\APIs;

use App\Http\Controllers\Controller;
use App\Models\ExamSchedule;
use App\Models\ExamStudentAssignment;
use App\Models\ExamTeacherAssignment;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class ExamScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $examSchedules = ExamSchedule::with(['teachers', 'students'])->get();
            return response()->json($examSchedules, 200);
        } catch (Exception $e) {
            return $this->handleException($e, 'Failed to retrieve exam schedules');
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'exam_id' => 'required|exists:exams,id',
            'section_id' => 'required|exists:sections,id',
            'subject' => 'required|string',
            'date'=> 'required|date',
            'start_time' =>'required|date',
            'end_time' => 'required|date|after:start_date',
            'teachers' => 'required|array',
            'teachers.*.teacher_id' => 'required|string',
            'teachers.*.role' => 'nullable|array',
            'students' => 'required|array',
            'students.*.student_id' => 'required|string'
        ]);

        DB::beginTransaction();

        try{
            $examSchedule = ExamSchedule::create([
                'exam_id' => $validated['exam_id'],
                'section_id' => $validated['section_id'],
                'subject' => $validated['subject'],
                'date' => $validated['date'],
                'start_time' => $validated['start_time'],
                'end_time' => $validated['end_time'],
            ]);

            $teachers = [];
            foreach ($validated['teachers'] as $teacher) {
                $teachers[] = ExamTeacherAssignment::create([
                    'exam_schedule_id' => $examSchedule->id,
                    'teacher_id' => $teacher['teacher_id'],
                    'role' => $teacher['role'] ?? null,
                ]);
            }

            // Assign Students
            $students = [];
            foreach ($validated['students'] as $student) {
                $students[] = ExamStudentAssignment::create([
                    'exam_schedule_id' => $examSchedule->id,
                    'student_id' => $student['student_id'],
                ]);
            }

            DB::commit();

            $examScheduleData = $examSchedule->toArray();
            $examScheduleData['teachers'] = $teachers;
            $examScheduleData['students'] = $students;

            return response()->json($examScheduleData, 201);
        } catch (Exception $e) {
            DB::rollBack();
            return $this->handleException($e, 'Failed to create exam schedule');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $examSchedule = ExamSchedule::with(['teachers', 'students'])->find($id);

            if (!$examSchedule) {
                return response()->json([
                    'message' => 'Exam schedule not found'
                ], 404);
            }

            return response()->json([
                'message' => 'Exam schedule retrieved successfully',
                'data' => $examSchedule
            ], 200);
        } catch (Exception $e) {
            return $this->handleException($e, 'Failed to retrieve exam schedule');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $examSchedule = ExamSchedule::findOrFail($id);

        $validated = $request->validate([
            'exam_id' => 'required|exists:exams,id',
            'section_id' => 'required|exists:sections,id',
            'subject' => 'required|string',
            'date' => 'required|date',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after:start_time',
            'teachers' => 'required|array',
            'teachers.*.teacher_id' => 'required|string',
            'teachers.*.role' => 'nullable|string',
            'students' => 'required|array',
            'students.*.student_id' => 'required|string',
        ]);

        DB::beginTransaction();

        try {
            $examSchedule->update([
                'exam_id' => $validated['exam_id'],
                'section_id' => $validated['section_id'],
                'subject' => $validated['subject'],
                'date' => $validated['date'],
                'start_time' => $validated['start_time'],
                'end_time' => $validated['end_time'],
            ]);

            // Update Teachers
            ExamTeacherAssignment::where('exam_schedule_id', $examSchedule->id)->delete();
            foreach ($validated['teachers'] as $teacher) {
                ExamTeacherAssignment::create([
                    'exam_schedule_id' => $examSchedule->id,
                    'teacher_id' => $teacher['teacher_id'],
                    'role' => $teacher['role'] ?? null,
                ]);
            }

            // Update Students
            ExamStudentAssignment::where('exam_schedule_id', $examSchedule->id)->delete();
            foreach ($validated['students'] as $student) {
                ExamStudentAssignment::create([
                    'exam_schedule_id' => $examSchedule->id,
                    'student_id' => $student['student_id'],
                ]);
            }

            DB::commit();

            return response()->json([
                'message' => 'Exam schedule updated successfully',
                'data' => $examSchedule
            ], 200);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $e->errors(),
            ], 422);
        } catch (Exception $e) {
            DB::rollBack();
            return $this->handleException($e, 'Failed to update exam schedule');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $examSchedule = ExamSchedule::findOrFail($id);

        DB::beginTransaction();

        try {
            // Delete teacher and student assignments
            ExamTeacherAssignment::where('exam_schedule_id', $examSchedule->id)->delete();
            ExamStudentAssignment::where('exam_schedule_id', $examSchedule->id)->delete();

            // Delete the exam schedule
            $examSchedule->delete();

            DB::commit();

            return response()->json([
                'message' => 'Exam schedule deleted successfully'
            ], 200);
        } catch (Exception $e) {
            DB::rollBack();
            return $this->handleException($e, 'Failed to delete exam schedule');
        }
    }
}
