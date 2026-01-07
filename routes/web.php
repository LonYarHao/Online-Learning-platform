<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SocialLoginController;

require __DIR__.'/admin.php';
require __DIR__.'/teacher.php';
require __DIR__.'/student.php';

Route::get('/', function () {
    return view('Front.index');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';


Route::get('/auth/{provider}/redirect', [SocialLoginController::class,'redirect'])->name('socialRedirect');

Route::get('/auth/{provider}/callback', [SocialLoginController::class,'callback'])->name('socialCallBack');
