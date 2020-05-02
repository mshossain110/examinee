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

Auth::routes();

Route::get('/', 'HomeController')->name('home');
Route::get('/courses/{course:slug}', 'CourseController@show')->name('course.show');

Route::group(['middleware' => ['auth']], function(){

	Route::get("/learning/my-courses/{any?}", "LearningController@myCourses")->name("learning.courses")->where('any', '.*');
	Route::get("/instructor/courses/{any?}", "InstructorController@courses")->name("instructor.courses")->where('any', '.*');

	Route::post('/download', 'DownloadController@download');
    Route::get('/uploads/{id}/{any?}', 'UploadController')->where('any', '.*');

	Route::post("/subscribe/{course}", 'CourseController@subscribe')->name('course.subscribe');
});
