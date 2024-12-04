<?php

namespace App\Http\Controllers\APIs;

use App\Http\Controllers\Controller;
use App\Models\Section;
use Illuminate\Http\Request;

class SectionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sections = Section::all();

        return response()->json($sections, 200);
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
        $request->validate([
            'name' => 'required|string|max:255',
            'academic_year_id' => 'required|exists:academic_years,id',
            'teacher_id' => 'required|string'
        ],[
            'name.unique' => 'This class already exists for the selected academic year.'
        ]);

        $section = Section::create($request->all());

        return response()->json($section, 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $section = Section::find($id);

        if(!$section) {
            return response()->json(['message'=> 'Class not found'], 404);
        }

        return response()->json($section, 200);

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
        $section = Section::find($id);

        if(!$section) {
            return response()->json(['message' => 'Class not found'], 404);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'academic_year_id' => 'required|exists:academic_years,id',
            'teacher_id' => 'required|string'
        ],[
            'name.unique' => 'This class already exists for the selected academic year.'
        ]);

        $section->update($request->all());

        return response()->json($section,200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $section = Section::find($id);

        if(!$section) {
            return response()->json(['message' => 'Class not found'], 404);
        }

        $section->delete();

        return response()->json(['message' => 'Class deleted successfully'], 200);
    }
}
