<?php

namespace App\Http\Controllers\APIs;

use Exception;
use App\Models\Holiday;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\HolidayResource;

class HolidayController extends Controller
{
    public function getHolidayData(Request $request){
        try{
            $data = Holiday::get();

            $holidays = HolidayResource::collection($data);

            return response()->json($holidays, 200);
        } catch (Exception $e) {
            return $this->handleException($e, 'Failed to retrieve holiday');
        }
    }


    public function store(Request $request){
        try{
            $request->validate([
                "name" => "required"
            ]);

            $holiday = new Holiday;
            $holiday->name = $request->name;
            $holiday->save();

            return response()->json($holiday, 200);
            } catch (Exception $e) {
                return $this->handleException($e, 'Failed to create holiday');
            }
    }
}
