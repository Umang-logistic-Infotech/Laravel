<?php

use App\Http\Controllers\StudentController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InvokableController;
use App\Http\Controllers\ResourceController;
use App\Http\Controllers\TeacherController;

Route::get('/', function () {
    return view('home');
});


Route::get('/program_1', function () {
    echo "Inside Program 1";
});

Route::post('/program_1/post', function () {
    return view('welcome');
});


Route::prefix('detail')->group(function () {
    Route::get('/teacher', function () {
        echo "Teacher page";
    })->name('teacher-details');

    Route::get('student', function () {
        echo "Student page";
    })->name('student-details');
});

Route::get('student/{id}', function ($id) {
    echo "Student " . $id;
});


Route::get('/invoke', InvokableController::class);

Route::resource('/resource', ResourceController::class);

Route::view('/aboutUs', 'aboutUs');
Route::view('/contactUs', 'contactUs');

Route::controller(StudentController::class)->group(function () {
    Route::get('aboutstudent/{id}/{name}', 'aboutStudent');
    Route::get('getStudents',  'getStudents');
    Route::get('getStudentsCount',  'getStudentsCount');
    Route::get('addStudent', 'addStudent');
    Route::get('getStudent/{id}', 'getStudent');
    Route::get('updateStudent/{id}', 'updateStudent');
    Route::get('deleteStudent/{id}', 'deleteStudent');
    Route::get('deletedStudents', 'deletedStudents');
});

Route::controller(TeacherController::class)->group(function () {
    Route::get('teachers',  'index');
    Route::get('addTeacher', 'add');
    Route::get('getTeacher/{id}', 'getTeacher');
    Route::get('updateTeacher/{id}', 'updateTeacher');
    Route::get('deleteTeacher/{id}', 'deleteTeacher');
});

Route::fallback(function () {
    return "please enter valid url";
});
