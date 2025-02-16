<?php

namespace App\Http\Controllers\APIs;

use Exception;
use App\Models\Subject;
use Illuminate\Http\Request;
use App\Models\SectionSubject;
use App\Models\Section;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

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

    public function getSubjectData(Request $request)
    {
        try {
            $request->validate([
                'section_Id' => 'required',
            ]);
        
            if ($request->has('filterBy') && $request->input('filterBy') !== '') {
                // Get the academic class id for the section
                $academicClassId = Section::where('id', $request->input('section_Id'))
                                ->value('academic_class_id');
        
                if (!$academicClassId) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Invalid section ID'
                    ], 400);
                }
        
                // Retrieve assigned subject IDs as an array
                $assignedSubjectIds = SectionSubject::where('section_id', $request->input('section_Id'))
                                            ->pluck('subject_id')
                                            ->toArray();

                $assignedSubjectIds = array_map('intval', $assignedSubjectIds);
                
        
                // Build the query for subjects within the same academic class
                $subjects = Subject::
                            where('academic_class_id', $academicClassId)->
                            whereNotIn('id', $assignedSubjectIds)->
                            get();
        
                return response()->json($subjects);
            }
        
            // Old logic: return subjects that are already assigned to the section
            $data = SectionSubject::where('section_id', $request->input('section_Id'))
                            ->join('subjects', 'subjects.id', '=', 'sections_subjects.subject_id')
                            ->select('subjects.id', 'subjects.name', 'subjects.description', 'subjects.code')
                            ->get();
        
            return response()->json($data);
        
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
        
    }
    /**
     * Store a newly created resource in storage.
     */

    public function createSubject(Request $request){
        try {
            DB::beginTransaction();

            $request->validate([
                'name' => 'required|string',
                'code' => 'required|string|unique:subjects,code',
                'description' => 'nullable|string',
                'academic_class_id' => "required|exists:academic_classes,id",
                'section_id' => "required|exists:sections,id"
            ]);

            $subject = Subject::create($request->all());

            $section_subject = SectionSubject::create([
                "section_id" => $request->section_id,
                "subject_id" => $subject->id
            ]);

            DB::commit();
            return response()->json($subject, 200);
        } catch (Exception $e) {
            DB::rollBack();
            return $this->handleException($e, 'Failed to create subject');
        }
    }

    public function addSubject(Request $request){
        try {

            $request->validate([
                'sectionId' => "required|exists:sections,id",
                'subjects' => "required|array",
                'subject_id.*' => "exists:subjects,id",
            ]);

            $section_subjects = [];
            foreach ($request->subjects as $subjectId) {
                $section_subjects[] = [
                    "section_id" => $request->sectionId,
                    "subject_id" => $subjectId['id'],
                    "created_at" => now(),
                    "updated_at" => now()
                ];
            }

            $sec_sub = SectionSubject::insert($section_subjects);

            return response()->json($sec_sub, 200);
        } catch (Exception $e) {

            return $this->handleException($e, 'Failed to create subject');
        }
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string',
                'code' => 'required|string|unique:subjects,code',
                'description' => 'nullable|string',
                'academic_class_id' => "required|exists:academic_classes,id"
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
