<?php

use App\Http\Controllers\CourseController;
use App\Http\Controllers\DownloadController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InstructorController;
use App\Http\Controllers\LearningController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UploadController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;


Route::get('/', HomeController::class)->name('home');
Route::get('/courses/{course:slug}', [CourseController::class, 'show'])->name('course.show');

Route::group(['middleware' => ['auth']], function(){

	Route::get("/learning/my-courses/{any?}", [LearningController::class,  'myCourses' ])->name("learning.courses")->where('any', '.*');
	Route::get("/instructor/courses/{any?}", [InstructorController::class, 'courses'])->name("instructor.courses")->where('any', '.*');

	Route::post('/download', [DownloadController::class, 'download']);
    Route::get('/uploads/{id}/{any?}', UploadController::class)->where('any', '.*');

	Route::post("/subscribe/{course}", [CourseController::class, 'subscribe'])->name('course.subscribe');
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
