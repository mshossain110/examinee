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

	Route::get('course/{slug}', ['uses' => 'CoursesController@show', 'as' => 'courses.show']);

});


Route::group(['middleware' => 'auth'], function(){
	Route::post('/logout', 'AuthController@logout')->name('logout');
});



Route::group(['middleware' => ['auth', 'teacher']], function(){
	Route::get('/home', 'HomeController@index')->name('home');
	Route::resource('exam', 'ExamController');
	Route::resource('subject', 'SubjectController');
	Route::resource('topic', 'TopicController');

	Route::get('question', 'QuestionController@index')->name('question.index');
	Route::get('question/create/{todo}', 'QuestionController@create')->name('question.create');
	Route::post('question', 'QuestionController@store')->name('question.store');
	Route::get('question/{question}', 'QuestionController@show')->name('question.show');
	Route::get('question/{question}/edit/{todo}', 'QuestionController@edit')->name('question.edit');
	Route::put('question/{question}', 'QuestionController@update')->name('question.update');
	Route::delete('question/{question}', 'QuestionController@destroy')->name('question.destroy');

	// Route::resource('courses', 'Admin\CoursesController');
});

Route::group(['middleware' => ['auth', 'student']], function(){
	Route::get('/dashboard', 'StudentController@index')->name('student.home');
	Route::get('exam/{exam}/start', 'ExamController@start')->name('exam.start');
	Route::post('exam/{exam}/end', 'ExamController@end' )->name('exam.end');
	Route::get('student/exam/results', 'StudentController@ResultSHow' )->name('results');
});

