<?php

use App\Http\Controllers\APIs\AcademicYearController;
use App\Http\Controllers\APIs\AttendanceController;
use App\Http\Controllers\APIs\CertificateController;
use App\Http\Controllers\APIs\ExamController;
use App\Http\Controllers\APIs\GradeController;
use App\Http\Controllers\APIs\SectionController;
use App\Http\Controllers\APIs\SubjectController;
use App\Http\Controllers\APIs\TimeTableController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Route::group(['middleware' => ['auth.jwt']], function () {
//     Route::apiResource('academic-years', AcademicYearController::class);
//     Route::apiResource('grades', GradeController::class);
//     Route::apiResource('subjects', SubjectController::class);
//     Route::apiResource('classes', SectionController::class);
//     Route::apiResource('time-tables', TimeTableController::class);
//     Route::apiResource('exams',ExamController::class);
//     Route::get('attendances', [AttendanceController::class, 'index']);
//     Route::post('attendances', [AttendanceController::class, 'recordAttendance']);
//     Route::post('certificates', [CertificateController::class, 'addCertificate']);
// });

Route::middleware('auth:employee')->group(function(){
    Route::apiResource('academic-years', AcademicYearController::class);
    Route::apiResource('grades', GradeController::class);
    Route::apiResource('subjects', SubjectController::class);
    Route::apiResource('classes', SectionController::class);
    Route::apiResource('time-tables', TimeTableController::class);
    Route::apiResource('exams',ExamController::class);
    Route::get('attendances', [AttendanceController::class, 'index']);
    Route::post('attendances', [AttendanceController::class, 'recordAttendance']);
    Route::post('certificates', [CertificateController::class, 'addCertificate']);
});