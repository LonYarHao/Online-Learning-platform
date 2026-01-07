<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\Student\ProfileController;
use App\Http\Controllers\Student\StudentController;
use App\Http\Controllers\Student\StudentAssignmentController;

Route::prefix('student')->middleware('student')->group(function () {
    Route::get('dashboard',[StudentController::class,'dashboard'])->name('student#dashboard');

    Route::prefix('profile')->group(function () {
     Route::get('changePasswordPage',[ProfileController::class,'changePasswordPage'])->name('student#changePasswordPage');
     Route::post('changePassword',[ProfileController::class,'changePassword'])->name('student#changePassword');
     Route::get('detail',[ProfileController::class,'detail'])->name('student#ProfileDetail');
     Route::post('update',[ProfileController::class,'update'])->name('student#ProfileUpdate');
});
    Route::prefix('course')->group(function () {
        Route::get('browselist', [StudentController::class, 'browselist'])->name('student#browselist');
        Route::get('detail/{id}',[StudentController::class,'detail'])->name('student#courseDetail');
        Route::post('course/rating', [StudentController::class, 'saveRating'])->name('student#saveRating');


    });

    Route::prefix('payment')->group(function () {
         Route::get('paymentPage/{id}', [StudentController::class, 'paymentPage'])->name('student#paymentPage');
         Route::post('createPayment',[StudentController::class,'createPayment'])->name('student#createPayment');
         Route::get('mycourse',[StudentController::class,'mycourse'])->name('student#myCourse');
         Route::get('paymentHistory',[StudentController::class,'paymentHistory'])->name('student#paymentHistory');
         Route::get('deleteHistory/{id}',[StudentController::class,'deleteHistory'])->name('student#deleteHistory');
    });

    Route::prefix('comment')->group(function () {

        Route::post('store', [CommentController::class, 'storeComment'])->name('comment#store');
        Route::delete('delete/{id}', [CommentController::class, 'deleteComment'])->name('comment#delete');
    });

    Route::prefix('assignment')->group(function () {
        Route::get('myAssignment',[StudentAssignmentController::class,'myAssignment'])->name('student#myAssignment');
        Route::get('viewAssignment/{id}',[StudentAssignmentController::class,'viewAssignment'])->name('student#viewAssignment');
        Route::post('submitAssignment', [StudentAssignmentController::class, 'submitAssignment'])->name('student#submitAssignment');

    });

    Route::prefix('notification')->group(function () {
        Route::get('noti',[StudentController::class,'noti'])->name('student#Noti');
    });

    Route::prefix('grade')->group(function () {
        Route::get('myGrade',[StudentController::class,'myGrade'])->name('student#myGrade');
        Route::get('gradePage', [StudentController::class, 'gradePage'])->name('student#gradePage');
        Route::get('gradeDetail/{id}', [StudentController::class, 'gradeDetail'])->name('student#gradeDetail');
    });

    Route::prefix('report')->group(function () {
        Route::get('viewReport',[StudentController::class,'viewReport'])->name('student#viewReport');
        Route::get('create', [StudentController::class, 'createReportPage'])->name('student#createReportPage');
        Route::post('send', [StudentController::class, 'sendReport'])->name('student#sendReport');
    });

});


