<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\CourseVideoController;
use App\Http\Controllers\FrontController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SubscribeTranscationController;
use App\Http\Controllers\TeacherController;
use Illuminate\Support\Facades\Route;

Route::get('/', [FrontController::class, 'index'])->name('front.index');

Route::get('/details/{course:slug}', [FrontController::class, 'course'])->name('front.course');

Route::get('/details/{category:slug}', [FrontController::class, 'category'])->name('front.category');

Route::get('/details/{pricing:slug}', [FrontController::class, 'pricing'])->name('front.pricing');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/checkout', [FrontController::class, 'checkout'])->name('front.checkout');
    Route::post('/checkout/store', [FrontController::class, 'checkout_store'])->name('front.checkout.store');

    Route::prefix('admin')->name('admin.')->group(function(){
        // kategori
        Route::resource('categories', CategoryController::class)->middleware('role:owner');

        // guru
        Route::resource('teachers', TeacherController::class)->middleware('role:owner');

        // kelas
        Route::resource('courses', CourseController::class)->middleware('role:owner|teacher');

        // transaksi
        Route::resource('subscribe_transactions', SubscribeTranscationController::class)->middleware('role:owner');

        // video
        Route::resource('course_videos', CourseVideoController::class)->middleware('role:owner|teacher');
    });

});

require __DIR__.'/auth.php';
