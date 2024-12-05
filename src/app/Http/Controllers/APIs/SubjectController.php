<?php

namespace App\Http\Controllers\APIs;

use App\Http\Controllers\Controller;
use App\Models\Subject;
use Illuminate\Http\Request;
use Exception;

class SubjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $subjects = Subject::all();
            return response()->json($subjects, 200);
        } catch (Exception $e) {
            return $this->handleException($e, 'Failed to fetch subjects');
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string',
                'code' => 'required|string|unique:subjects,code',
                'description' => 'nullable|string',
            ]);

            $subject = Subject::create($request->all());

            return response()->json($subject, 200);
        } catch (Exception $e) {
            return $this->handleException($e, 'Failed to create subject');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $subject = Subject::findOrFail($id);

            return response()->json($subject, 200);
        } catch (Exception $e) {
            return $this->handleException($e, 'Failed to fetch the subject');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $subject = Subject::findOrFail($id);

            $request->validate([
                'name' => 'required|string',
                'code' => 'required|string|unique:subjects,code',
                'description' => 'nullable|string',
            ]);

            $subject->update($request->all());

            return response()->json($subject, 200);
        } catch (Exception $e) {
            return $this->handleException($e, 'Failed to update the subject');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $subject = Subject::findOrFail($id);

            $subject->delete();

            return response()->json(['message' => 'Subject deleted successfully'], 200);
        } catch (Exception $e) {
            return $this->handleException($e, 'Failed to delete the subject');
        }
    }
}
