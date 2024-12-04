<?php

namespace App\Http\Controllers\APIs;

use App\Http\Controllers\Controller;
use App\Http\Resources\TimeTableResource;
use App\Models\TimeTable;
use Illuminate\Http\Request;

class TimeTableController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $timetables = TimeTable::with(['class','subject'])->get();

        return response()->json(TimeTableResource::collection($timetables), 200);
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
            'class_id' => 'required|exists:sections,id',
            'subject_id' => 'required|exists:subjects,id',
            'teacher_id' => 'required|string',
            'day_of_week' => 'required|string|in:Monday,Tuesday,Wednesday,Thursday,Friday,Saturday,Sunday',
            'time_start' => 'required|date_format:H:i',
            'time_end' => 'required|date_format:H:i|after:time_start',
            'term' => 'required|string|max:50',
        ]);

        $timeTable = TimeTable::create($request->all());

        return response()->json($timeTable, 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $timeTable = TimeTable::with(['class','subject'])->findOrFail($id);

        return response()->json($timeTable, 200);
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
        $timetable = TimeTable::findOrFail($id);

        $validatedData = $request->validate([
            'class_id' => 'required|exists:sections,id',
            'subject_id' => 'required|exists:subjects,id',
            'teacher_id' => 'required|string',
            'day_of_week' => 'required|string|in:Monday,Tuesday,Wednesday,Thursday,Friday,Saturday,Sunday',
            'time_start' => 'required|date_format:H:i',
            'time_end' => 'required|date_format:H:i|after:time_start',
            'academic_year' => 'required|string',
            'term' => 'required|string',
        ]);

        $timetable->update($validatedData);

        return response()->json(new TimetableResource($timetable), 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $timeTable = TimeTable::findOrFail($id);
        $timeTable->delete();

        return response()->json(['message' => 'Timetables deleted successfully'], 200);
    }
}
