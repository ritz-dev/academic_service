<?php

namespace App\Http\Controllers\APIs;

use App\Http\Controllers\Controller;
use App\Models\AcademicClass;
use App\Models\Section;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class AcademicClassController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

    }

    public function getAcademicClass(Request $request)
    {
        try {
            $data = AcademicClass::with('academicYear')->get();

            return response()->json($data);

        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function getClassData(Request $request)
    {
        try {
            $request->validate([
                'academic_year_Id' => 'required',
            ]);

            $data = AcademicClass::where('academic_year_id', $request->input('academic_year_Id'))
                        ->select(['id', 'name'])
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
            'name' => 'required|string|max:255|unique:academic_classes,name',
            'academicYear' => 'required|string|max:255',
        ], [
            'name.unique' => 'This class already exists for the selected academic year'
        ]);

        try{
            $class = AcademicClass::create([
                'id' => Str::uuid(),
                'name' => $request->input('name'),
                'academic_year_id' => $request->input('academicYear')
            ]);

            return response()->json($class, 200);

        } catch (Exception $e) {
            return $this->handleException($e, 'Failed to create section');
        }
    }

    /**
     * Display the specified resource.
     */

    public function showAcademicClass($id){
        try {
            $academic_class = AcademicClass::with('academicYear')->where('id',$id)->get();
            return response()->json($academic_class, 200);
        } catch (Exception $e) {

            return $this->handleException($e, 'Failed to fetch the class');
        }
    }

    public function showClass(Request $request){
        try{
            $class_id = $request->slug;
            $academic_class = AcademicClass::with('academicYear')->where('id',$class_id)->get();
            return response()->json($academic_class, 200);
        }catch (Exception $e){
            return $this->handleException($e, 'Failed to fetch the class');
        }
    }

    public function show(string $id)
    {
        $academic_class = AcademicClass::findOrFail($id);
        return response()->json($academic_class);
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
        try{
            $request->validate([
                'name' => [
                    'required',
                    'string',
                    'max:255',
                    Rule::unique('academic_classes', 'name')->ignore($id),
                ],
                'academicYear' => 'required|string|max:255',
            ], [
                'name.unique' => 'This class already exists for the selected academic year'
            ]);

            $class = AcademicClass::findOrFail($request->class_id);
            $class->name = $request->name;
            $class->academic_year_id = $request->academicYear;
            $class->save();

            return response()->json($class, 200);
        }catch (Exception $e){
            return $this->handleException($e, 'Failed to fetch the class');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
