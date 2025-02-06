<?php

namespace App\Http\Controllers\APIs;

use App\Http\Controllers\Controller;
use App\Models\Section;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Http;

class SectionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $token = $request->header('Authorization');
            $select = $request->input('select', null);
            $limit = $request->input('limit', 15);
            $page = $request->input('page', 1);
            $orderBy = $request->input('orderBy', 'sections.created_at');
            $sortedBy = $request->input('sortedBy', 'desc');
            $search = $request->input('search', '');
            $offset = ($page - 1) * $limit;

            $validOrderColumns = ['sections.created_at', 'sections.updated_at'];
            $validSortDirections = ['asc', 'desc'];

            $orderBy = in_array($orderBy, $validOrderColumns) ? $orderBy : 'sections.created_at';
            $sortedBy = in_array($sortedBy, $validSortDirections) ? $sortedBy : 'desc';

            $dataArray = Section::where('academic_class_id',$select)->selectRaw('ROW_NUMBER() OVER(ORDER BY '.$orderBy.' '.$sortedBy.') as number,
                                sections.id as id,
                                sections.name as name
                            ')
                            ->when($search, function ($query, $search) {
                                $query->where(function ($query) use ($search) {
                                    $query->where('sections.name', 'like', "%{$search}%");
                                });
                            });

            $total = $dataArray->get()->count();

            $data = $dataArray
                ->orderBy($orderBy, $sortedBy)
                ->skip($offset)
                ->take($limit)
                ->get();

            foreach ($data as $section) {
                $teacherInfo = $this->fetchTeacherInfo($token, $section->teacher_id);
                
                $section->teacher = $teacherInfo;
            }

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

    private function fetchTeacherInfo($token, $teacherId)
    { 
        $userManagementServiceUrl = config('services.user_management.url') . '/teachers' . '/846961ed-7776-4204-b802-63c6775b12b6';
        
        try { 
            $response = Http::withHeaders([ 
                'Accept' => 'application/json', 
                'Authorization' => $token,  
            ])->get($userManagementServiceUrl);

            return json_decode($response->getBody()->getContents(), true);

            if ($response->failed()) {
                return ['error' => 'Unable to fetch teacher info']; 
            } 
            
            return $response->json(); 
        } catch (\Exception $e) { 
            return ['error' => 'Service unavailable', 'details' => $e->getMessage()]; 
        } 
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'academic_year_id' => 'required|exists:academic_years,id',
                'grade_id'=> 'required|exists:grades,id',
                'teacher_id' => 'required|string'
            ], [
                'name.unique' => 'This section already exists for the selected class.'
            ]);

            $section = Section::create($request->all());

            return response()->json($section, 200);

        } catch (Exception $e) {
            return $this->handleException($e, 'Failed to create section');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $section = Section::findOrFail($id);

            return response()->json($section, 200);
        } catch (Exception $e) {

            return $this->handleException($e, 'Failed to fetch the class');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $section = Section::findOrFail($id);

            $request->validate([
                'name' => 'required|string|max:255',
                'academic_year_id' => 'required|exists:academic_years,id',
                'academic_class_id'=> 'required|exists:academic_class,id',
                'teacher_id' => 'required|string'
            ], [
                'name.unique' => 'This class already exists for the selected academic year.'
            ]);

            $section->update($request->all());

            return response()->json($section, 200);
        } catch (Exception $e) {
            return $this->handleException($e, 'Failed to update the class');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $section = Section::findOrFail($id);

            $section->delete();

            return response()->json(['message' => 'Class deleted successfully'], 200);
        } catch (Exception $e) {
            return $this->handleException($e, 'Failed to delete the class');
        }
    }

    public function assignTeacher(Request $request)
    {
        try {

            $validated = $request->validate([
                'id' => 'required|exists:sections,id',
                'teacher.label' => 'required|string',
                'teacher.value' => 'required|string',
            ]);

            $section = Section::findOrFail($validated['id']);
            $section->teacher_id = $validated['teacher']['value'];
            $section->save();

            return response()->json($section, 200);
        } catch (Exception $e) {
            return $this->handleException($e, 'Failed to update the class');
        }
    }
}
