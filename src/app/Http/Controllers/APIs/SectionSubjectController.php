<?php

namespace App\Http\Controllers\APIs;

use App\Models\Section;
use App\Models\Subject;
use Illuminate\Http\Request;
use App\Models\SectionSubject;
use App\Http\Controllers\Controller;

class SectionSubjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $select = $request->input('select', null);
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

            // $dataArray = Subject::select('subjects.id', 'subjects.name', 'subjects.description', 'subjects.code')
            //             ->join('sections_subjects', 'sections_subjects.subject_id', '=', 'subjects.id')
            //             ->where('sections_subjects.section_id', $select)
            //             ->when($search, function ($query, $search) {
            //                 $query->where('subjects.name', 'like', "%{$search}%");
            //             });
            $dataArray = SectionSubject::where('section_id', $select)
                        ->join('subjects', 'subjects.id', '=', 'sections_subjects.subject_id')
                        ->selectRaw('ROW_NUMBER() OVER(ORDER BY '.$orderBy.' '.$sortedBy.') as number,
                            subjects.id as id,
                            subjects.name as name,
                            subjects.description as description,
                            subjects.code as code')
                        ->when($search, function ($query, $search) {
                            $query->where('subjects.name', 'like', "%{$search}%");
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

    public function getSubjectData(Request $request)
    {
        try {

            $section_Id = $request->input('section_Id');

            $data = SectionSubject::where('section_id', $section_Id)
                        ->join('subjects', 'subjects.id', '=', 'sections_subjects.subject_id')
                        ->select('subjects.name','subjects.description','subjects.code')
                        ->get();

            return response()->json($data);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ],500);
        }
    }

    public function getSectionData(Request $request)
    {
        try {


            $class_Id = $request->input('class_Id');

            $data = Section::where('academic_class_id', $class_Id)
                        ->select(['id','name'])
                        ->get();

            return response()->json($data);
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
        //
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
