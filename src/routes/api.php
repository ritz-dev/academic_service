<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\APIs\ExamController;
use App\Http\Controllers\APIs\GradeController;
use App\Http\Controllers\APIs\SectionController;
use App\Http\Controllers\APIs\SubjectController;
use App\Http\Controllers\APIs\TimeTableController;
use App\Http\Controllers\APIs\AttendanceController;
use App\Http\Controllers\APIs\CertificateController;
use App\Http\Controllers\APIs\AcademicYearController;
use App\Http\Controllers\APIs\AcademicClassController;
use App\Http\Controllers\APIs\AcademicClassSubjectController;
use App\Http\Controllers\APIs\SectionSubjectController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::group(['middleware' => ['auth.jwt']], function () {
    Route::apiResource('academic-years', AcademicYearController::class);
    Route::apiResource('classes', AcademicClassController::class);
    Route::apiResource('grades', GradeController::class);
    Route::apiResource('subjects', SubjectController::class);
    Route::apiResource('section-subjects', SectionSubjectController::class);
    Route::apiResource('sections', SectionController::class);
    Route::apiResource('academic_class_subjects',AcademicClassSubjectController::class);
    Route::apiResource('time-tables', TimeTableController::class);
    Route::apiResource('exams',ExamController::class);
    Route::get('attendances', [AttendanceController::class, 'index']);
    Route::post('attendances', [AttendanceController::class, 'recordAttendance']);
    Route::post('certificates', [CertificateController::class, 'addCertificate']);
    Route::post('sections/assign-teacher',[SectionController::class, 'assignTeacher']);
    Route::post('get-subject-data', [SectionSubjectController::class,'getSubjectData']);
});

