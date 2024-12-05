<?php

namespace App\Http\Controllers\APIs;

use App\Http\Controllers\Controller;
use App\Models\Section;
use Illuminate\Http\Request;
use Exception;

class SectionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {

            $sections = Section::all();
            return response()->json($sections, 200);

        } catch (Exception $e) {
            
            return $this->handleException($e, 'Failed to fetch sections');
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'academic_year_id' => 'required|exists:academic_years,id',
                'teacher_id' => 'required|string'
            ], [
                'name.unique' => 'This class already exists for the selected academic year.'
            ]);

            $section = Section::create($request->all());

            return response()->json($section, 200);

        } catch (Exception $e) {
            return $this->handleException($e, 'Failed to create section');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $section = Section::findOrFail($id);

            return response()->json($section, 200);
        } catch (Exception $e) {

            return $this->handleException($e, 'Failed to fetch the class');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $section = Section::findOrFail($id);

            $request->validate([
                'name' => 'required|string|max:255',
                'academic_year_id' => 'required|exists:academic_years,id',
                'teacher_id' => 'required|string'
            ], [
                'name.unique' => 'This class already exists for the selected academic year.'
            ]);

            $section->update($request->all());

            return response()->json($section, 200);
        } catch (Exception $e) {
            return $this->handleException($e, 'Failed to update the class');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $section = Section::findOrFail($id);

            $section->delete();

            return response()->json(['message' => 'Class deleted successfully'], 200);
        } catch (Exception $e) {
            return $this->handleException($e, 'Failed to delete the class');
        }
    }
}
