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

Route::group(['middleware' => 'guest'], function(){
	Route::get('/', function () {
	    return view('welcome');
	});
	Route::get('/login', 'AuthController@index')->name('login');

	Route::post('/login/store', 'AuthController@store')->name('login.store');

	Route::get('/register', 'AuthController@registerView')->name('register');

	Route::post('/register/store', 'AuthController@register')->name('register.store');

});


Route::group(['middleware' => 'auth'], function(){
	Route::post('/logout', 'AuthController@logout')->name('logout');
});


Route::group(['middleware' => ['auth', 'teacher']], function(){
	Route::get('/home', 'HomeController@index')->name('home');
	Route::resource('exam', 'ExamController');
	Route::resource('subject', 'SubjectController');
	Route::resource('topic', 'TopicController');
	Route::resource('question', 'QuestionController');
});

Route::group(['middleware' => ['auth', 'student']], function(){
	Route::get('/dashboard', 'StudentController@index')->name('student.home');
	Route::get('exam/{exam}/start', 'ExamController@start')->name('exam.start');
	Route::post('exam/{exam}/end', 'ExamController@end' )->name('exam.end');
});

