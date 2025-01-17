<?php

namespace App\Http\Controllers\APIs;

use App\Http\Controllers\Controller;
use App\Models\AcademicClass;
use App\Models\AcademicClassSubject;
use App\Models\Section;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class AcademicClassController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $limit = $request->input('limit', 15);
            $page = $request->input('page', 1);
            $orderBy = $request->input('orderBy', 'academic_classes.created_at');
            $sortedBy = $request->input('sortedBy', 'desc');
            $search = $request->input('search', '');
            $offset = ($page - 1) * $limit;

            $validOrderColumns = ['academic_classes.created_at', 'academic_classes.updated_at'];
            $validSortDirections = ['asc', 'desc'];

            $orderBy = in_array($orderBy, $validOrderColumns) ? $orderBy : 'academic_classes.created_at';
            $sortedBy = in_array($sortedBy, $validSortDirections) ? $sortedBy : 'desc';

            $dataArray = AcademicClass::with('sections','subjects')->selectRaw('ROW_NUMBER() OVER(ORDER BY '.$orderBy.' '.$sortedBy.') as number,
                                academic_classes.id as id,
                                academic_classes.name as name
                            ')
                            ->when($search, function ($query, $search) {
                                $query->where(function ($query) use ($search) {
                                    $query->where('academic_classes.name', 'like', "%{$search}%");
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
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'academicYear' => 'required|string|max:255',
            'section' => 'required|array|min:1',
            'section.*.name' => 'required|string|max:255',
            'subjects' => 'required|array|min:1',
            'subjects.*.name' => 'required|string|max:255',
            'subjects.*.id' => 'required|integer|exists:subjects,id',
        ], [
            'name.unique' => 'This class already exists for the selected academic year'
        ]);

        DB::beginTransaction();

        try{
            $class = AcademicClass::create([
                'id' => Str::uuid(),
                'name' => $request->input('name')
            ]);

            foreach($validated['subjects'] as $subject) {
                AcademicClassSubject::create([
                    'id' => Str::uuid(),
                    'academic_class_id' => $class->id,
                    'subject_id' => $subject['id']
                ]);
            }

            foreach($validated['section'] as $section) {
                Section::create([
                    'id' => Str::uuid(),
                    'name' => $section['name'],
                    'academic_year_id' => $validated['academicYear'],
                    'academic_class_id' => $class->id,
                    'teacher_id' => 1
                ]);
            }

            DB::commit();

            return response()->json([
                'id' => $validated['academicYear']
            ]);
        } catch (Exception $e) {
            DB::rollBack();
            return $this->handleException($e, 'Failed to create section');
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
