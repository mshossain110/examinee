<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\UploadController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DownloadController;
use App\Http\Controllers\LearningController;
use App\Http\Controllers\Admin\ExamController;
use App\Http\Controllers\InstructorController;
use App\Http\Controllers\Admin\RolesController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\Admin\LessonController;
use App\Http\Controllers\Admin\TopicsController;
use App\Http\Controllers\Admin\CoursesController;
use App\Http\Controllers\Admin\SectionController;
use App\Http\Controllers\Admin\SubjectController;
use App\Http\Controllers\Admin\QuestionController;
use App\Http\Controllers\Auth\SocialiteController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ServerInfoController;
use App\Http\Controllers\Admin\CourseStudentController;


Route::get('/', HomeController::class)->name('home');
Route::get('/courses/{course:slug}', [CourseController::class, 'show'])->name('course.show');
Route::get("/instructor/{user:name}/course", [InstructorController::class, 'courses'])->name("instructor.courses");

Route::post('/oauth/{driver}', [SocialiteController::class, 'getSocialRedirect'])->name('oauth');
Route::get('/oauth/{driver}/callback', [SocialiteController::class, 'handleSocialCallback'])->name('oauth.callback');

Route::group(['middleware' => ['auth']], function(){
    Route::get("/learning/my-courses", [LearningController::class,  'myCourses' ])->name("learning.courses");
    Route::get("/learning/{course:slug}", [LearningController::class,  'startCourse' ])->name("start.course");
    Route::get("/learning/{course:slug}/{type}/{slog}", [LearningController::class,  'singleResource' ])->name("start.resource");
    Route::post('/download', [DownloadController::class, 'download']);
    Route::get('/uploads/{id}/{any?}', UploadController::class)->where('any', '.*');
    Route::post("/subscribe/{course}", [CourseController::class, 'subscribe'])->name('course.subscribe');
});

Route::middleware(['auth', 'verified'])->prefix('/dashboard')->name('admin.')->group(function () {
    Route::get('/', DashboardController::class)->name('dashboard');
    Route::resource('users', UsersController::class);
    Route::resource('roles', RolesController::class);
    Route::get('courses/{course}/students', CourseStudentController::class)->name('course-student');
    Route::apiResource('courses/{course:id}/sections', SectionController::class)->except(['show', 'edit']);
    Route::resource('courses', CoursesController::class);
    Route::apiResource('courses/{course:id}/lessons', LessonController::class);
    Route::resource('topics', TopicsController::class)->except(['show']);
    Route::resource('subjects', SubjectController::class)->except(['show']);
    Route::resource('exams', ExamController::class)->except(['show']);
    Route::resource('exams/{exam:id}/questions', QuestionController::class)->except(['show']);
    Route::get('/server-info', [ServerInfoController::class, 'index'])->name('server-info');
    Route::post('/oauth-revoke/{provider}', [SocialiteController::class, 'revokeSocialProvider']);
});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

