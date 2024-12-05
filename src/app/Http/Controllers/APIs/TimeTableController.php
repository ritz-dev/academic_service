<?php

namespace App\Http\Controllers\APIs;

use App\Http\Controllers\Controller;
use App\Http\Resources\TimeTableResource;
use App\Models\TimeTable;
use Illuminate\Http\Request;
use Exception;

class TimeTableController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $timetables = TimeTable::with(['class','subject'])->get();
            return response()->json(TimeTableResource::collection($timetables), 200);
        } catch (Exception $e) {
            return $this->handleException($e, 'Failed to fetch timetables');
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
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
        } catch (Exception $e) {
            return $this->handleException($e, 'Failed to create timetable');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $timeTable = TimeTable::with(['class','subject'])->findOrFail($id);
            return response()->json($timeTable, 200);
        } catch (Exception $e) {
            return $this->handleException($e, 'Failed to fetch timetable');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
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

            return response()->json(new TimeTableResource($timetable), 200);
        } catch (Exception $e) {
            return $this->handleException($e, 'Failed to update timetable');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $timeTable = TimeTable::findOrFail($id);
            $timeTable->delete();

            return response()->json(['message' => 'Timetable deleted successfully'], 200);
        } catch (Exception $e) {
            return $this->handleException($e, 'Failed to delete timetable');
        }
    }
}
