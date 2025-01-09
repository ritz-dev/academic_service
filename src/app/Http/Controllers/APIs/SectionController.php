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

            $sections = Section::all();

            foreach ($sections as $section) {
                $teacherInfo = $this->fetchTeacherInfo($token, $section->teacher_id);
               
                $section->teacher = $teacherInfo;
            }
            return response()->json($sections, 200);

        } catch (Exception $e) {
            return $this->handleException($e, 'Failed to fetch sections');
        }
    }

    private function fetchTeacherInfo($token, $teacherId)
    { 
        $userManagementServiceUrl = config('services.user_management.url') . '/teachers' . '/f1368b92-579e-4bfd-aded-9d5f30f058aa';
        
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
                'name.unique' => 'This class already exists for the selected academic year.'
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
                'grade_id'=> 'required|exists:grades,id',
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
}
