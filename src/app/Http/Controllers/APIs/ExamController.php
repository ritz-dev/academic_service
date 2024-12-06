<?php

namespace App\Http\Controllers\APIs;

use App\Http\Controllers\Controller;
use App\Models\Exam;
use Exception;
use Illuminate\Http\Request;

class ExamController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $exams = Exam::all();
            return response()->json($exams, 200);
        } catch (Exception $e) {
            return $this->handleException($e, 'Failed to fetch exams');
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
        try {
            $request->validate([
                'name' => 'required|string',
                'start_date' => 'required|date',
                'end_date' => 'required|date',
                'academic_year_id' => 'required|exists:academic_years,id',
            ]);

            $exam = Exam::create($request->all());

            return response()->json($exam, 200);
        } catch (Exception $e) {
            return $this->handleException($e, 'Failed to create exam');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $exam = Exam::findOrFail($id);

            return response()->json($exam, 200);
        } catch (Exception $e) {
            return $this->handleException($e, 'Failed to fetch the exam');
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
        try {
            $exam = Exam::findOrFail($id);

            $request->validate([
                'name' => 'required|string',
                'start_date' => 'required|date',
                'end_date' => 'required|date',
                'academic_year_id' => 'required|exists:academic_years,id',
            ]);

            $exam->update($request->all());

            return response()->json($exam, 200);
        } catch (Exception $e) {
            return $this->handleException($e, 'Failed to update the exam');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $exam = Exam::findOrFail($id);

            $exam->delete();

            return response()->json(['message' => 'Exam deleted successfully'], 200);
        } catch (Exception $e) {
            return $this->handleException($e, 'Failed to delete the exam');
        }
    }
}
