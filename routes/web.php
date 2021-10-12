<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use App\Http\Controllers\API\CourseController;
use App\Http\Controllers\DownloadController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InstructorController;
use App\Http\Controllers\LearningController;
use App\Http\Controllers\UploadController;

Auth::routes();

Route::get('/', HomeController::class)->name('home');
Route::get('/courses/{course:slug}', 'CourseController@show')->name('course.show');

Route::group(['middleware' => ['auth']], function(){

	Route::get("/learning/my-courses/{any?}", [LearningController::class,  'myCourses' ])->name("learning.courses")->where('any', '.*');
	Route::get("/instructor/courses/{any?}", [InstructorController::class, 'courses'])->name("instructor.courses")->where('any', '.*');

	Route::post('/download', [DownloadController::class, 'download']);
    Route::get('/uploads/{id}/{any?}', UploadController::class)->where('any', '.*');

	Route::post("/subscribe/{course}", [CourseController::class, 'subscribe'])->name('course.subscribe');
});
