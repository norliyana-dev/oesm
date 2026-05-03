<?php

use App\Http\Controllers\ClassroomController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ExamController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\StudentExamController;
use App\Http\Controllers\SubjectController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::middleware(['role:lecturer'])->group(function () {
        Route::resource('classroom', ClassroomController::class)->only(['index', 'create', 'store', 'edit', 'update', 'destroy']);
        Route::resource('subject', SubjectController::class)->only(['index', 'create', 'store', 'edit', 'update', 'destroy']);
        Route::resource('exam', ExamController::class)->only(['index', 'create', 'store', 'edit', 'update', 'destroy']);   
        Route::resource('exam.questions', QuestionController::class)->only(['index', 'create', 'store', 'edit', 'update', 'destroy']);  
    });

    Route::middleware(['role:student'])->group(function () {
        Route::get('/student/my-classroom', [StudentController::class, 'myClassroom'])->name('student.classroom');
        Route::get('/student/exams', [StudentExamController::class, 'index'])->name('student.exam');
        Route::get('/student/exams/{exam}/start', [StudentExamController::class, 'start'])->name('student.exam.start');
        Route::post('/student/exams/{exam}/submit', [StudentExamController::class, 'submit'])->name('student.exam.submit');
    });
});

require __DIR__.'/auth.php';
