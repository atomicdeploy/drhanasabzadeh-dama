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
    
    // Categories (using 'cat' to match production)
    Route::get('/cat', [App\Http\Controllers\Admin\CategoryController::class, 'index'])->name('cat.index');
    Route::get('/cat/create', [App\Http\Controllers\Admin\CategoryController::class, 'create'])->name('cat.create');
    Route::post('/cat', [App\Http\Controllers\Admin\CategoryController::class, 'store'])->name('cat.store');
    Route::get('/cat/{category}', [App\Http\Controllers\Admin\CategoryController::class, 'show'])->name('cat.show');
    Route::get('/cat/{category}/edit', [App\Http\Controllers\Admin\CategoryController::class, 'edit'])->name('cat.edit');
    Route::put('/cat/{category}', [App\Http\Controllers\Admin\CategoryController::class, 'update'])->name('cat.update');
    Route::delete('/cat/{category}', [App\Http\Controllers\Admin\CategoryController::class, 'destroy'])->name('cat.destroy');
    Route::get('/api/categories', [App\Http\Controllers\Admin\CategoryController::class, 'getCategories'])->name('api.categories');
    
    // Channels
    Route::resource('channels', App\Http\Controllers\Admin\ChannelController::class);
    
    // Live Sessions
    Route::resource('live', App\Http\Controllers\Admin\LiveSessionController::class);
    Route::get('/live/{session}/comments', [App\Http\Controllers\Admin\LiveSessionController::class, 'comments'])->name('live.comments');
    
    // Exams
    Route::resource('exam', App\Http\Controllers\Admin\ExamController::class);
    
    // Channel Posts
    Route::resource('channelposts', App\Http\Controllers\Admin\ChannelPostController::class);
    
    // Discounts
    Route::resource('discount', App\Http\Controllers\Admin\DiscountController::class);
    Route::post('/api/discount/validate', [App\Http\Controllers\Admin\DiscountController::class, 'validateCode'])->name('api.discount.validate');
    
    // Stories
    Route::resource('story', App\Http\Controllers\Admin\StoryController::class);
    
    // Users
    Route::get('/userlist', function() {
        return view('admin.users.index');
    })->name('userlist');
    
    // Teachers
    Route::get('/teachers', function() {
        return view('admin.teachers.index');
    })->name('teachers.index');
    
    // Orders
    Route::get('/order', function() {
        return view('admin.orders.index');
    })->name('order.index');
    
    // Future routes placeholder
    // More routes will be added as controllers are implemented
});
