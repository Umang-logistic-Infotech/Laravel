<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StudentController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InvokableController;
use App\Http\Controllers\ResourceController;
use App\Http\Controllers\TeacherController;
use Illuminate\Support\Facades\Auth;
use App\Http\Middleware\AdminMiddleware;

Route::get('/', function () {
    $students = (new StudentController)->index(request());
    $user = Auth::user();

    return view('homeOld', compact('students', 'user'));
    // return view('welcome');
})->middleware('auth');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


Route::get('/invoke', InvokableController::class);

Route::resource('/resource', ResourceController::class);

Route::view('/aboutUs', 'aboutUs')->middleware('auth');
Route::view('/contactUs', 'contactUs')->middleware('auth');
// Route::view('/editStudent', 'updateStudent');

Route::controller(StudentController::class)->group(function () {

    Route::get('aboutstudent/{id}/{name}', 'aboutStudent')->middleware('auth');
    Route::get('getStudents',  'getStudents')->middleware('auth');
    Route::get('getStudentsCount',  'getStudentsCount')->middleware('auth');
    Route::get('addStudent', 'addStudent')->middleware('auth');
    Route::post('createStudent', 'createStudent')->middleware('auth');
    Route::get('getStudent/{id}', 'getStudent')->middleware(AdminMiddleware::class);
    Route::post('updateStudent/{id}', 'updateStudent')->middleware('auth');
    Route::delete('deleteStudent/{id}', 'deleteStudent')->middleware('auth');
    Route::get('deletedStudents', 'deletedStudents')->middleware('auth');
});

Route::controller(TeacherController::class)->group(function () {
    Route::get('teachers',  'index')->middleware('auth');
    Route::get('addTeacher', 'add')->middleware('auth');
    Route::get('getTeacher/{id}', 'getTeacher')->middleware('auth');
    Route::get('updateTeacher/{id}', 'updateTeacher')->middleware('auth');
    Route::get('deleteTeacher/{id}', 'deleteTeacher')->middleware('auth');
});

Route::fallback(function () {
    return "please enter valid url";
});
require __DIR__ . '/auth.php';
