<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\AssignmentController;
use App\Http\Controllers\Teacher\ProfileController;
use App\Http\Controllers\Teacher\TeacherController;

Route::prefix('teacher')->middleware('teacher')->group(function () {
    Route::get('dashboard',[TeacherController::class,'dashboard'])->name('teacher#dashboard');

    Route::prefix('profile')->group(function () {
    Route::get('changePasswordPage',[ProfileController::class,'changePasswordPage'])->name('teacher#changePasswordPage');
    Route::post('changePassword',[ProfileController::class,'changePassword'])->name('teacher#changePassword');
    Route::get('detail',[ProfileController::class,'detail'])->name('teacher#profileDetail');
    Route::post('update',[ProfileController::class,'update'])->name('teacher#profileUpdate');
    Route::get('myStudents', [TeacherController::class, 'myStudents'])->name('teacher#myStudents');
});


    Route::prefix('course')->group(function () {
        Route::get('createCoursePage',[CourseController::class,'createCoursePage'])->name('teacher#createCoursePage');
        Route::post('createCourse',[CourseController::class,'createCourse'])->name('teacher#createCourse');
        Route::get('myCourses', [CourseController::class, 'myCourses'])->name('teacher#myCourses');
        Route::get('edit/{id}',[CourseController::class,'editCourse'])->name('teaceher#editCourse');
        Route::post('update',[CourseController::class,'updateCourse'])->name('teacher#updateCourse');
    });

    Route::prefix('assignment')->group(function () {
        Route::get('myAssignment',[AssignmentController::class,'myAssignment'])->name('teacher#myAssignment');
        Route::get('createAssignmentPage',[AssignmentController::class,'createAssignmentPage'])->name('teacher#createAssignmentPage');
        Route::post('createAssignment', [AssignmentController::class, 'createAssignment'])->name('teacher#createAssignment');
        Route::get('deleteAssignment/{id}',[AssignmentController::class,'deleteAssignment'])->name('teacher#deleteAssignment');
    });

    Route::prefix('notification')->group(function () {
        Route::get('noti',[TeacherController::class,'noti'])->name('teacher#Noti');
    });

    Route::prefix('grade')->group(function () {
        Route::get('teacherGrade/{id}',[TeacherController::class,'teacherGrade'])->name('teacher#Grade');
        Route::post('submitGrade/{id}',[TeacherController::class,'submitGrade'])->name('teacher#submitGrade');

        Route::get('myGrade',[TeacherController::class,'myGrade'])->name('teacher#myGrade');
    });

    Route::prefix('report')->group(function () {
        Route::get('viewReport',[TeacherController::class,'viewReport'])->name('teacher#viewReport');
        Route::get('create', [TeacherController::class, 'createReportPage'])->name('teacher#createReportPage');
        Route::post('send', [TeacherController::class, 'sendReport'])->name('teacher#sendReport');
    });
});


