<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\ExamController;
use App\Http\Controllers\API\FileController;
use App\Http\Controllers\API\CourseController;
use App\Http\Controllers\API\LessonController;
use App\Http\Controllers\API\SessionController;
use App\Http\Controllers\API\SubjectController;
use App\Http\Controllers\API\MyCourseController;
use App\Http\Controllers\API\QuestionController;
use App\Http\Controllers\API\TakeExamController;
use App\Http\Controllers\API\SessionableController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('courses/my-courses', [MyCourseController::class, 'index']);
    Route::get('courses/my-courses/{course:slug}', [MyCourseController::class, 'show']);

    
    Route::apiResource('course', CourseController::class);

    Route::put('sessions/{session}/attach-exam', [SessionController::class,'attachExam']);
    Route::put('sessions/{session}/attach-lession', [SessionController::class, 'attacLession']);

    Route::get('take-exam/{exam}', [TakeExamController::class, 'show']);
    Route::post('start-exam/{exam}', [TakeExamController::class, 'start']);
    Route::post('complete-exam/{exam}', [TakeExamController::class, 'complete']);
    Route::post('answer/{exam}', [TakeExamController::class, 'answer']);

    Route::apiResource('/files', FileController::class);
});


Route::get('courses/{course}/sessions', [SessionableController::class, 'lessons']);