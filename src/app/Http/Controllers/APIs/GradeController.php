<?php

namespace App\Http\Controllers\APIs;

use App\Http\Controllers\Controller;
use App\Http\Resources\GradeResource;
use App\Models\Grade;
use Illuminate\Http\Request;

class GradeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $gradeAll = Grade::All();

        return response()->json(GradeResource::collection($gradeAll));
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
            'grade' => 'required|string|unique:grades'
        ]);

        $grade = Grade::create($request->all());

        return response()->json($grade, 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $grade = Grade::find($id);

        if(!$grade) {
            return response()->json(['message'=>'Grede not found', 404]);
        }

        return response()->json($grade, 200);
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
        $grade = Grade::find($id);

        if(!$grade) {
            return response()->json(['message'=> 'Grade not found', 404]);
        }

        $request-> validate([
            'grade' => 'required|string|unique:grade'
        ]);

        $grade->update($request->all());

        return response()->json($grade, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $grade = Grade::find($id);

        if(!$grade) {
            return response()->json(['message' => 'Grade not found']);
        }

        $grade->delete();

        return response()->json(['message' => 'Grade deleted successfully'], 200);
    }
}
