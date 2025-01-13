<?php

namespace App\Http\Controllers\APIs;

use App\Http\Controllers\Controller;
use App\Models\Subject;
use Illuminate\Http\Request;
use Exception;

class SubjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $limit = $request->input('limit', 15);
            $page = $request->input('page', 1);
            $orderBy = $request->input('orderBy', 'subjects.created_at');
            $sortedBy = $request->input('sortedBy', 'desc');
            $search = $request->input('search', '');
            $offset = ($page - 1) * $limit;

            $validOrderColumns = ['subjects.created_at', 'subjects.updated_at'];
            $validSortDirections = ['asc', 'desc'];

            $orderBy = in_array($orderBy, $validOrderColumns) ? $orderBy : 'subjects.created_at';
            $sortedBy = in_array($sortedBy, $validSortDirections) ? $sortedBy : 'desc';


            $dataArray = Subject::selectRaw('ROW_NUMBER() OVER(ORDER BY '.$orderBy.' '.$sortedBy.') as number,
                            id,
                            name,
                            description,
                            code')
                        ->when($search, function ($query, $search) {
                            $query->where(function ($query) use ($search) {
                                $query->where('name', 'like', "%{$search}%");
                            });
                        });

            $total = $dataArray->get()->count();

            $data = $dataArray
                ->orderBy($orderBy, $sortedBy)
                ->skip($offset)
                ->take($limit)
                ->get();

            return response()->json([
                "message" => "success",
                "total" => $total,
                "data" => $data
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ],500);
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
                'code' => 'required|string|unique:subjects,code',
                'description' => 'nullable|string',
            ]);

            $subject = Subject::create($request->all());

            return response()->json($subject, 200);
        } catch (Exception $e) {
            return $this->handleException($e, 'Failed to create subject');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $subject = Subject::findOrFail($id);

            return response()->json($subject, 200);
        } catch (Exception $e) {
            return $this->handleException($e, 'Failed to fetch the subject');
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
            $subject = Subject::findOrFail($id);

            $request->validate([
                'name' => 'required|string',
                'code' => 'required|string|unique:subjects,code',
                'description' => 'nullable|string',
            ]);

            $subject->update($request->all());

            return response()->json($subject, 200);
        } catch (Exception $e) {
            return $this->handleException($e, 'Failed to update the subject');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $subject = Subject::findOrFail($id);

            $subject->delete();

            return response()->json(['message' => 'Subject deleted successfully'], 200);
        } catch (Exception $e) {
            return $this->handleException($e, 'Failed to delete the subject');
        }
    }
}
