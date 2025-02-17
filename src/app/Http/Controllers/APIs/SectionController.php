<?php

namespace App\Http\Controllers\APIs;

use App\Http\Controllers\Controller;
use App\Models\Section;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;


class SectionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

    }

    public function getSectionData(Request $request)
    {
        try {

            $request->validate([
                'class_Id' => 'required',
            ]);

            $data = Section::where('academic_class_id',$request->input('class_Id'))
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
                'academicClassId'=> 'required',
            ], [
                'name.unique' => 'This section already exists for the selected class.'
            ]);

            $section = Section::create([
                'id' => Str::uuid(),
                'name' => $request->input('name'),
                'academic_class_id' => $request->input('academicClassId'),
            ]);

            return response()->json($section, 200);

        } catch (Exception $e) {
            return $this->handleException($e, 'Failed to create section');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        try{
            $section_id = $request->slug;
            $section = Section::where('id',$section_id)->select('id','name','teacher_id as teacherId','academic_class_id as academicClassId')->first();
            $section->academicClassId = (string)$section->academicClassId;
            return response()->json($section, 200);
        }catch (Exception $e){
            return $this->handleException($e, 'Failed to fetch the section');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'academicClassId' => 'required|exists:academic_classes,id',
                'teacherId' => 'required|string'
            ]);

            $section = Section::findOrFail($id);
            $section->name = $request->name;
            $section->academic_class_id = $request->academicClassId;
            $section->teacher_id = $request->teacherId;
            $section->save();

            return response()->json(200);
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
