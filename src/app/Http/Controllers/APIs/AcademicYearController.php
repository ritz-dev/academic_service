<?php

namespace App\Http\Controllers\APIs;

use App\Http\Controllers\Controller;
use App\Http\Resources\AcademicYearResource;
use App\Models\AcademicYear;
use Exception;
use Illuminate\Http\Request;

class AcademicYearController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $academicYearsAll = AcademicYear::all();
            return response()->json(AcademicYearResource::collection($academicYearsAll), 200);

        } catch (Exception $e) {

            return $this->handleException($e, 'Failed to fetch academic years');
        }
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
        try {
            $request->validate([
                'year' => 'required|string|unique:academic_years',
                'start_date' => 'required|date',
                'end_date' => 'required|date|after:start_date',
            ]);

            $academicYear = AcademicYear::create($request->all());
            return response()->json($academicYear, 201); // 201 Created

        } catch (Exception $e) {

            return $this->handleException($e, 'Failed to create academic year');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $academicYear = AcademicYear::findOrFail($id);
            return response()->json($academicYear, 200);

        } catch (Exception $e) {

            return $this->handleException($e, 'Failed to fetch the academic year');
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
            $academicYear = AcademicYear::findOrFail($id);

            $validatedData = $request->validate([
                'year' => 'required|string|unique:academic_years,year,' . $id,
                'start_date' => 'required|date',
                'end_date' => 'required|date|after:start_date',
            ]);

            $academicYear->update($validatedData);

            return response()->json($academicYear, 200);
        } catch (Exception $e) {

            return $this->handleException($e, 'Failed to update the academic year');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $academicYear = AcademicYear::findOrFail($id);
            $academicYear->delete();

            return response()->json(['message' => 'Academic year deleted successfully'], 200);
        } catch (Exception $e) {

            return $this->handleException($e, 'Failed to delete the academic year');
        }
    }
}
