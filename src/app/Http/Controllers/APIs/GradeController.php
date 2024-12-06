<?php

namespace App\Http\Controllers\APIs;

use App\Http\Controllers\Controller;
use App\Http\Resources\GradeResource;
use App\Models\Grade;
use App\Services\BlockChainService;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;

class GradeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    protected $blockchainService;

    public function __construct(BlockChainService $blockchainService)
    {
        $this->blockchainService = $blockchainService;
    }

    public function index()
    {
        try {
            $gradeAll = Grade::All();
            return response()->json(GradeResource::collection($gradeAll), 200);
        } catch (Exception $e) {
            return $this->handleException($e, 'Failed to fetch grades');
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'student_id' => 'required|exists:students,id',
                'exam_id' => 'required|exists:exams,id',
                'subject_id' => 'required|exists:subjects,id',
                'mark' => 'required|integer|min:0|max:100',
                'date' => 'required|date',
                'grade' => 'required|string|max:10',
            ]);

            $previousHash = $this->blockchainService->getPreviousHash(Grade::class);
            $timestamp = now();
            $calculatedHash = $this->blockchainService->calculateHash(
                $previousHash,
                json_encode($request->all()),
                $timestamp->format('Y-m-d H:i:s')
            );

            $gradeData = $request->all();
            $gradeData['previous_hash'] = $previousHash;
            $gradeData['hash'] = $calculatedHash;


            $grade = Grade::create($gradeData);

            return response()->json($grade, 201); // 201 Created
        } catch (Exception $e) {
            return $this->handleException($e, 'Failed to create grade');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function verifyGrade(Request $request)
    {
        // Find the grade by its ID
        $grade = Grade::findOrFail($request->id);

        if (!$grade) {
            return response()->json(['message' => 'grade not found'], 404);
        }

        // Convert timestamp to Carbon instance if it's stored as a string
        $timestamp = Carbon::parse($grade->timestamp);

        // Recalculate hash based on grade data
        $calculatedHash = $this->blockchainService->calculateHash(
            $grade->previous_hash,
            json_encode($grade),
            $timestamp->format('Y-m-d H:i:s') // Ensure timestamp is formatted correctly
        );

        // Compare the calculated hash with the stored hash
        if ($calculatedHash !== $grade->hash) {
            return response()->json(['message' => 'Grade has been tampered with'], 400);
        }

        // Check if the previous hash matches the previous Grade's hash (if it exists)
        if ($grade->previous_hash === '0000000000000000000000000000000000000000000000000000000000000000') {
            return response()->json(['message' => 'Grade is valid and verified'], 200);
        }

        $previousGrade= Grade::where('hash', $grade->previous_hash)->first();

        if ($previousGrade) {
            return response()->json(['message' => 'Grade is valid and verified'], 200);
        }

        return response()->json(['message' => 'Invalid Grade chain'], 400);
    }
}
