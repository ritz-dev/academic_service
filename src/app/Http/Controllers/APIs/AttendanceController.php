<?php

namespace App\Http\Controllers\APIs;

use App\Http\Controllers\Controller;
use App\Http\Resources\AttendanceResource;
use App\Models\Attendance;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function index()
    {
        $attendance =  Attendance::with(['timetable'])->get();

        return response()->json(AttendanceResource::collection($attendance), 200);
    }

    public function recordAttendance(Request $request)
    {
        $request->validate([
            'timetable_id' => 'required|exists:time_tables,id',
            'attendee_id' => 'required|string',
            'attendee_type' => 'required|in:student,teacher',
            'status' => 'required|in:present,absent,late',
            'date' => 'required|date',
            'remarks' => 'nullable|string',
        ]);
    
        $attendance = Attendance::create($request->all());
    
        return response()->json($attendance,200);
    }
}
