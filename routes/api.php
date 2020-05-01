<?php

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

Route::group(['middleware' => ['auth:sanctum'], 'namespace' => 'API'], function () {
    Route::get('courses/my-courses', 'MyCourseController@index');
    Route::get('courses/my-courses/{course:slug}', 'MyCourseController@show');

    

    Route::get('courses/{course}/students', 'CourseController@students');
    Route::apiResource('course', 'CourseController');
    Route::apiResource('lessons', 'LessonController');
    Route::apiResource('topics', 'TopicController');

    Route::apiResource('subjects', 'SubjectController');
    Route::put('sessions/{session}/attach-exam', 'SessionController@attachExam');
    Route::put('sessions/{session}/attach-lession', 'SessionController@attacLession');
    
    Route::apiResource('sessions', 'SessionController');

    Route::apiResource('exams', 'ExamController');
    Route::apiResource('questions', 'QuestionController');
    Route::get('take-exam/{exam}', 'TakeExamController@show');
    Route::post('start-exam/{exam}', 'TakeExamController@start');
    Route::post('complete-exam/{exam}', 'TakeExamController@complete');
    Route::post('answer/{exam}', 'TakeExamController@answer');

    
    Route::apiResource('/files', 'FileController');
});


Route::get('courses/{course}/sessions', 'API\SessionableController@lessons');