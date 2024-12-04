<?php

namespace App\Http\Controllers\APIs;

use App\Http\Controllers\Controller;
use App\Http\Resources\AttendanceResource;
use App\Models\Attendance;
use App\Services\BlockChainService;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    protected $blockchainService;

    public function __construct(BlockChainService $blockchainService)
    {
        $this->blockchainService = $blockchainService;
    }

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
    
        $previousHash = $this->blockchainService->getPreviousHash(Attendance::class);
        $timestamp = now();
        $calculatedHash = $this->blockchainService->calculateHash(
            $previousHash,
            json_encode($request->all()),
            $timestamp->format('Y-m-d H:i:s')
        );

        $attendanceData = $request->all();
        $attendanceData['previous_hash'] = $previousHash;
        $attendanceData['hash'] = $calculatedHash;

        $attendance = Attendance::create($attendanceData);
    
        return response()->json($attendance,200);
    }
}
