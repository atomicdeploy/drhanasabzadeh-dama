<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect()->route('admin.dashboard');
});

// Admin Routes
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');
    
    // Categories
    Route::resource('categories', App\Http\Controllers\Admin\CategoryController::class);
    Route::get('/api/categories', [App\Http\Controllers\Admin\CategoryController::class, 'getCategories'])->name('categories.api');
    
    // Future routes for other entities
    // Route::resource('courses', App\Http\Controllers\Admin\CourseController::class);
    // Route::resource('teachers', App\Http\Controllers\Admin\TeacherController::class);
    // Route::resource('orders', App\Http\Controllers\Admin\OrderController::class);
});
