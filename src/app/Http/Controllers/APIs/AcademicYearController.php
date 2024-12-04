<?php

namespace App\Http\Controllers\APIs;

use App\Http\Controllers\Controller;
use App\Http\Resources\AcademicYearResource;
use App\Models\AcademicYear;
use Illuminate\Http\Request;

class AcademicYearController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $academicYearsAll = AcademicYear::all();
        
        return response()->json(AcademicYearResource::collection($academicYearsAll));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'year' => 'required|string|unique:academic_years',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
        ]);

        $academicYear = AcademicYear::create($request->all());

        return response()->json($academicYear, 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $academicYears = AcademicYear::find($id);

        if($academicYears) {
            return response()->json(['message'=> 'Academic year not found'], 404);
        }

        return response()->json($academicYears, 200);
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
        $academicYears = AcademicYear::find($id);

        if(!$academicYears) {
            return response()->json(['message'=> 'Academic year not found'], 404);
        }

        $request->validate([
            'year' => 'required|string|unique:academic_years,year,' . $id,
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
        ]);

        $academicYears->update($request->all());

        return response()->json($academicYears, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $academicYears = AcademicYear::find($id);

        if(!$academicYears) {
            return response()->json(['message' => 'Academic year not found'], 404);
        }

        $academicYears->delete();

        return response()->json(['message' => 'Academic year deleted successfully'], 200);
    }
}
