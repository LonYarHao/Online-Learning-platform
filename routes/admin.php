<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\CourseController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\Admin\ProfileController;


Route::prefix('admin')->middleware('admin')->group(function () {
    Route::get('dashboard', [AdminController::class, 'dashboard'])->name('admin#dashboard');

    Route::prefix('account')->group(function () {
        Route::get('teacherlist',[AdminController::class,'teacherlist'])->name('account#teacherList');
        Route::get('studentlist',[AdminController::class,'studentlist'])->name('account#studentList');
    });

    Route::prefix('department')->group(function () {
        Route::get('list',[DepartmentController::class,'list'])->name('admin#departmentList');
        Route::post('create',[DepartmentController::class,'create'])->name('admin#departmentCreate');
        Route::get('delete/{id}',[DepartmentController::class,'delete'])->name('admin#departmentDelete');
        Route::get('edit/{id}',[DepartmentController::class,'edit'])->name('admin#departmentEdit');
        Route::post('update/{id}',[DepartmentController::class,'update'])->name('admin#departmentUpdate');

    });
    Route::prefix('course')->group(function () {
        Route::get('list',[CourseController::class,'courseList'])->name('admin#courseList');
        Route::get('delete/{id}',[CourseController::class,'courseDelete'])->name('admin#courseDelete');
    });

    Route::prefix('profile')->group(function () {
      Route::get('changePasswordPage',[ProfileController::class,'changePasswordPage'])->name('admin#changePasswordPage');
      Route::post('changePassword',[ProfileController::class,'changePassword'])->name('admin#changePassword');
      Route::get('detail',[ProfileController::class,'detail'])->name('admin#ProfileDetail');
      Route::post('update',[ProfileController::class,'update'])->name('account#update');
    });

    Route::prefix('payment')->group(function () {
        Route::get('paymentPage',[PaymentController::class,'paymentPage'])->name('admin#paymentPage');
        Route::post('updateStatus/{id}', [PaymentController::class, 'updateStatus'])->name('admin#paymentUpdateStatus');
    });

    Route::prefix('notification')->group(function () {
        Route::get('noti',[NotificationController::class,'noti'])->name('admin#Noti');
    });

    Route::prefix('report')->group(function () {
        Route::get('adminReport',[ReportController::class,'adminReport'])->name('admin#reportList');
        Route::get('deleteReport/{id}',[ReportController::class,'deleteReport'])->name('admin#deleteReport');
    });

    Route::group(['middleware' => 'superadmin'], function () {
      Route::prefix('account')->group(function () {
      Route::get('createAdminPage',[AdminController::class,'createAdminPage'])->name('account#createAdminPage');
      Route::post('createAdmin',[AdminController::class,'createAdmin'])->name('account#createAdmin');

      Route::get('adminlist',[AdminController::class,'adminlist'])->name('account#adminList');
      Route::get('adminDelete/{id}',[AdminController::class,'adminDelete'])->name('account#adminDelete');


      Route::get('createTeacherPage',[AdminController::class,'createTeacherPage'])->name('account#createTeacherPage');
      Route::post('createTeacher',[AdminController::class,'createTeacher'])->name('account#createTeacher');
      Route::get('teacherDelete/{id}',[AdminController::class,'teacherDelete'])->name('account#teacherDelete');




      Route::get('createStudentPage',[AdminController::class,'createStudentPage'])->name('account#createStudentPage');
      Route::post('createStudent',[AdminController::class,'createStudent'])->name('account#createStudent');
      Route::get('studentDelete/{id}',[AdminController::class,'studentDelete'])->name('account#studentDelete');
      });
    });

});

