<?php

namespace App\Http\Controllers\APIs;

use Exception;
use App\Models\TimeTable;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Database\Seeders\TimeTableSeeder;
use App\Http\Resources\TimeTableResource;

class TimeTableController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

    }

    public function getTimeTable(Request $request)
    {
        try {
            $request->validate([
                'sectionId' => 'required|exists:sections,id',
            ]);
            $section_id = $request->sectionId;
            $data = TimeTable::with(['academicClass','section','subject'])
                                    ->where('section_id',$section_id)
                                    ->get();

            $time_tables = TimeTableResource::collection($data);
            return response()->json($time_tables, 200);
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
                'title' => ['required', 'array'], // Ensure title is an array (object in JSON)
                'title.label' => ['required', 'string'], // Validate label property
                'title.value' => ['required', 'string'], // Validate value property
                'academicClassId' => 'required|exists:academic_classes,id',
                'sectionId' => 'required|exists:sections,id',
                'subjectId' => 'nullable|exists:subjects,id',
                'teacherId' => 'nullable',
                'room' => 'nullable',
                'date' => 'required|date_format:Y-m-d',
                'startTime' => 'nullable|date_format:H:i',
                'endTime' => 'nullable|date_format:H:i|after:startTime',
            ]);

            $time_table = new TimeTable;
            $time_table->title = $request->title['label'];
            $time_table->academic_class_id = $request->academicClassId;
            $time_table->section_id = $request->sectionId;
            $time_table->subject_id = $request->subjectId;
            $time_table->teacher_id = $request->teacherId;
            $time_table->room = $request->room;
            $time_table->date = $request->date;
            $time_table->start_time = $request->startTime;
            $time_table->end_time = $request->endTime;
            $time_table->is_holiday = $request->isHoliday;
            $time_table->save();

            return response()->json($time_table, 200);
        } catch (Exception $e) {
            return $this->handleException($e, 'Failed to create timetable');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        try {
            $time_table_id = $request->slug;
            $timeTable = TimeTable::with(['academicClass','section','subject'])->findOrFail($time_table_id);
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
            $request->validate([
                'title' => ['required', 'array'], // Ensure title is an array (object in JSON)
                'title.label' => ['required', 'string'], // Validate label property
                'title.value' => ['required', 'string'],
                'academicClassId' => 'required|exists:academic_classes,id',
                'sectionId' => 'required|exists:sections,id',
                'subjectId' => 'required|exists:subjects,id',
                'teacherId' => 'required',
                'room' => 'required',
                'date' => 'required|date_format:Y-m-d',
                'startTime' => 'required|date_format:H:i',
                'endTime' => 'required|date_format:H:i|after:startTime',
            ]);

            $data = TimeTable::findOrFail($id);
            $data->title = $request->title['label'];
            $data->academic_class_id = $request->academicClassId;
            $data->section_id = $request->sectionId;
            $data->subject_id = $request->subjectId;
            $data->teacher_id = $request->teacherId;
            $data->room = $request->room;
            $data->date = $request->date;
            $data->start_time = $request->startTime;
            $data->end_time = $request->endTime;
            $data->is_holiday = $request->isHoliday;
            $data->save();

            $time_table = new TimeTableResource($data);

            return response()->json($time_table, 200);
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
