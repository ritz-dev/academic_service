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

    public function index()
    {
        try {
            $gradeAll = Grade::All();
            return response()->json($gradeAll);
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
                'name' => 'required|string',
            ]);

            $grade = Grade::create($request->all());

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
        try{
            $grade = Grade::findOrFail($id);
            return response()->json($grade, 200);
        } catch (Exception $e) {
            return $this->handleException($e, 'Failed to fetch the grade');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try{
            $grade = Grade::findOrFail($id);

            $request->validate([
                'name' => 'required|string',
            ]);

            $grade->update($request->all());

            return response()->json($grade, 200);
        } catch (Exception $e) {
            return $this->handleException($e, 'Failed to update the grade.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $grade = Grade::findOrFail($id);

            $grade->delete();

            return response()->json(['message' => 'Grade deleted successfully']);
        } catch (Exception $e) {
            return $this->handleException($e, 'Failed to delete the exam');
        }
    }
}
