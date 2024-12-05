<?php

namespace App\Http\Controllers\APIs;

use App\Http\Controllers\Controller;
use App\Http\Resources\AttendanceResource;
use App\Models\Attendance;
use App\Services\BlockChainService;
use Carbon\Carbon;
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

    public function verifyAttendance(Request $request)
    {
        // Find the Attendance by its ID
        $attendance = Attendance::findOrFail($request->id);

        if (!$attendance) {
            return response()->json(['message' => 'Attendance not found'], 404);
        }

        // Convert timestamp to Carbon instance if it's stored as a string
        $timestamp = Carbon::parse($attendance->timestamp);

        // Recalculate hash based on Attendance data
        $calculatedHash = $this->blockchainService->calculateHash(
            $attendance->previous_hash,
            json_encode($attendance),
            $timestamp->format('Y-m-d H:i:s') // Ensure timestamp is formatted correctly
        );

        // Compare the calculated hash with the stored hash
        if ($calculatedHash !== $attendance->hash) {
            return response()->json(['message' => 'Attendance has been tampered with'], 400);
        }

        // Check if the previous hash matches the previous Attendance's hash (if it exists)
        if ($attendance->previous_hash === '0000000000000000000000000000000000000000000000000000000000000000') {
            return response()->json(['message' => 'Attendance is valid and verified'], 200);
        }

        $previousAttendance = Attendance::where('hash', $attendance->previous_hash)->first();

        if ($previousAttendance) {
            return response()->json(['message' => 'Attendance is valid and verified'], 200);
        }

        return response()->json(['message' => 'Invalid Attendance chain'], 400);
    }

}
