<?php

namespace App\Http\Controllers\APIs;

use App\Http\Controllers\Controller;
use App\Http\Resources\GradeResource;
use App\Models\Grade;
use Exception;
use Illuminate\Http\Request;

class GradeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $gradeAll = Grade::All();
            return response()->json(GradeResource::collection($gradeAll), 200);
        } catch (Exception $e) {
            return $this->handleException($e, 'Failed to fetch grades');
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'grade' => 'required|string|unique:grades'
            ]);

            $grade = Grade::create($request->all());
            
            return response()->json($grade, 201); // 201 Created
        } catch (Exception $e) {
            return $this->handleException($e, 'Failed to create grade');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $grade = Grade::findOrFail($id);

            if (!$grade) {
                return response()->json(['message' => 'Grade not found'], 404);
            }

            return response()->json($grade, 200);
        } catch (Exception $e) {
            return $this->handleException($e, 'Failed to fetch the grade');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $grade = Grade::findOrFail($id);

            if (!$grade) {
                return response()->json(['message' => 'Grade not found'], 404);
            }

            $request->validate([
                'grade' => 'required|string|unique:grades,grade,' . $id
            ]);

            $grade->update($request->all());
            return response()->json($grade, 200);
        } catch (Exception $e) {
            return $this->handleException($e, 'Failed to update the grade');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $grade = Grade::findOrFail($id);
            $grade->delete();
            return response()->json(['message' => 'Grade deleted successfully'], 200);
        } catch (Exception $e) {
            return $this->handleException($e, 'Failed to delete the grade');
        }
    }
}
