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
use App\Http\Controllers\APIs\ExamScheduleController;
use App\Http\Controllers\APIs\AcademicClassController;
use App\Http\Controllers\APIs\SectionSubjectController;
use App\Http\Controllers\APIs\AcademicClassSubjectController;


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
Route::post('get-academic-class',[AcademicClassController::class,'getAcademicClass']);
Route::post('get-academic-year',[AcademicYearController::class,'getAcademicYear']);
Route::post('get-attendance',[AttendanceController::class,'getAttendance']);
Route::post('get-exam',[ExamController::class,'getExam']);
Route::post('get-exam-schedule',[ExamScheduleController::class,'getExamSchedule']);
Route::post('get-grade',[GradeController::class,'getGrade']);
Route::post('get-section',[SectionController::class,'getSection']);
Route::post('get-subject',[SubjectController::class,'getSubject']);
Route::post('get-time-table',[TimeTableController::class,'getTimeTable']);
Route::post('get-class-data', [SectionSubjectController::class,'getClassData']);
Route::post('get-subject-data', [SectionSubjectController::class,'getSubjectData']);
Route::post('get-section-data', [SectionSubjectController::class,'getSectionData']);


