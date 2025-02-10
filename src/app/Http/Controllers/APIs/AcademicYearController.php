<?php

namespace App\Http\Controllers\APIs;

use App\Http\Controllers\Controller;
use App\Http\Resources\AcademicYearResource;
use App\Models\AcademicYear;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Str;


class AcademicYearController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

    }

    public function getAcademicYear(Request $request)
    {
        try {
            $limit = $request->input('limit', 15);
            $page = $request->input('page', 1);
            $orderBy = $request->input('orderBy', 'academic_years.created_at');
            $sortedBy = $request->input('sortedBy', 'desc');
            $search = $request->input('search', '');
            $offset = ($page - 1) * $limit;

            $validOrderColumns = ['academic_years.created_at', 'academic_years.updated_at'];
            $validSortDirections = ['asc', 'desc'];

            $orderBy = in_array($orderBy, $validOrderColumns) ? $orderBy : 'academic_years.created_at';
            $sortedBy = in_array($sortedBy, $validSortDirections) ? $sortedBy : 'desc';


            $dataArray = AcademicYear::selectRaw('ROW_NUMBER() OVER(ORDER BY '.$orderBy.' '.$sortedBy.') as number,
                                academic_years.id as id,
                                academic_years.year,
                                academic_years.start_date as startDate,
                                academic_years.end_date as endDate,
                                academic_years.is_active as isActive
                            ')
                            ->when($search, function ($query, $search) {
                                $query->where(function ($query) use ($search) {
                                    $query->where('academic_years.teacher_id', 'like', "%{$search}%");
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

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'year' => 'required|string|unique:academic_years',
                'startDate' => 'required|date',
                'endDate' => 'required|date|after:start_date',
            ]);

            $startDate = Carbon::parse($request->input('startDate'))->format('Y-m-d');
            $endDate = Carbon::parse($request->input('endDate'))->format('Y-m-d');

            $academicYear = AcademicYear::create([
                'id' => Str::uuid(),
                'year' => $request->input('year'),
                'start_date' => $startDate ,
                'end_date' => $endDate
            ]);

            return response()->json($academicYear, 201); // 201 Created

        } catch (Exception $e) {

            return $this->handleException($e, 'Failed to create academic year');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $data = AcademicYear::findOrFail($id);
            $academicYear = new AcademicYearResource($data);
            return response()->json($academicYear, 200);

        } catch (Exception $e) {

            return $this->handleException($e, 'Failed to fetch the academic year');
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
            $academicYear = AcademicYear::findOrFail($id);

            $validatedData = $request->validate([
                'year' => 'required|string|unique:academic_years,year,' . $id,
                'startDate' => 'required|date',
                'endDate' => 'required|date|after:start_date',
            ]);

            $startDate = Carbon::parse($request->input('startDate'))->format('Y-m-d');
            $endDate = Carbon::parse($request->input('endDate'))->format('Y-m-d');


            $academicYear->update([
                'year' => $request->input('year'),
                'start_date' => $startDate,
                'end_date' => $endDate,
            ]);

            return response()->json($academicYear, 200);
        } catch (Exception $e) {

            return $this->handleException($e, 'Failed to update the academic year');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $academicYear = AcademicYear::findOrFail($id);
            $academicYear->delete();

            return response()->json(['message' => 'Academic year deleted successfully'], 200);
        } catch (Exception $e) {

            return $this->handleException($e, 'Failed to delete the academic year');
        }
    }
}
