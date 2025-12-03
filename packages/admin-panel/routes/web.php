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
    
    // Comments Management
    Route::get('/comment', [App\Http\Controllers\Admin\CommentController::class, 'index'])->name('comment.index');
    Route::get('/comment/{id}/edit', [App\Http\Controllers\Admin\CommentController::class, 'edit'])->name('comment.edit');
    Route::put('/comment/{id}', [App\Http\Controllers\Admin\CommentController::class, 'update'])->name('comment.update');
    Route::get('/comment/destroy/{id}', [App\Http\Controllers\Admin\CommentController::class, 'destroy'])->name('comment.destroy');
    Route::get('/comment/approve/{id}', [App\Http\Controllers\Admin\CommentController::class, 'approve'])->name('comment.approve');
    Route::get('/comment/spam/{id}', [App\Http\Controllers\Admin\CommentController::class, 'markAsSpam'])->name('comment.spam');
    Route::post('/comment/bulk-approve', [App\Http\Controllers\Admin\CommentController::class, 'bulkApprove'])->name('comment.bulk-approve');
    Route::post('/comment/bulk-delete', [App\Http\Controllers\Admin\CommentController::class, 'bulkDelete'])->name('comment.bulk-delete');
    
    // Users Management
    Route::get('/userlist', [App\Http\Controllers\Admin\UserController::class, 'index'])->name('userlist');
    Route::get('/user/create', [App\Http\Controllers\Admin\UserController::class, 'create'])->name('user.create');
    Route::post('/user', [App\Http\Controllers\Admin\UserController::class, 'store'])->name('user.store');
    Route::get('/user/{id}', [App\Http\Controllers\Admin\UserController::class, 'show'])->name('user.show');
    Route::get('/user/{id}/edit', [App\Http\Controllers\Admin\UserController::class, 'edit'])->name('user.edit');
    Route::put('/user/{id}', [App\Http\Controllers\Admin\UserController::class, 'update'])->name('user.update');
    Route::delete('/user/{id}', [App\Http\Controllers\Admin\UserController::class, 'destroy'])->name('user.destroy');
    Route::get('/user/upload', [App\Http\Controllers\Admin\UserController::class, 'uploadForm'])->name('user.upload');
    Route::post('/user/upload', [App\Http\Controllers\Admin\UserController::class, 'uploadProcess'])->name('user.upload.process');
    
    // Teachers Management
    Route::resource('teachers', App\Http\Controllers\Admin\TeacherController::class);
    
    // Orders Management
    Route::get('/order', [App\Http\Controllers\Admin\OrderController::class, 'index'])->name('order.index');
    Route::get('/order/{id}', [App\Http\Controllers\Admin\OrderController::class, 'show'])->name('order.show');
    Route::put('/order/{id}/status', [App\Http\Controllers\Admin\OrderController::class, 'updateStatus'])->name('order.status');
    Route::get('/order/cardtocard', [App\Http\Controllers\Admin\OrderController::class, 'cardToCard'])->name('order.cardtocard');
    Route::get('/order/pay', [App\Http\Controllers\Admin\OrderController::class, 'paymentAttempts'])->name('order.pay');
    Route::post('/order/{id}/approve-card', [App\Http\Controllers\Admin\OrderController::class, 'approveCardPayment'])->name('order.approve-card');
    Route::post('/order/{id}/reject-card', [App\Http\Controllers\Admin\OrderController::class, 'rejectCardPayment'])->name('order.reject-card');
    
    // Course View Analytics
    Route::get('/courseview/course_viewing', [App\Http\Controllers\Admin\CourseViewController::class, 'courseViewing'])->name('courseview.viewing');
    Route::get('/courseview/chart', [App\Http\Controllers\Admin\CourseViewController::class, 'chart'])->name('courseview.chart');
    Route::get('/courseview/abandoned_courses', [App\Http\Controllers\Admin\CourseViewController::class, 'abandonedCourses'])->name('courseview.abandoned');
    
    // Settings
    Route::get('/setting', [App\Http\Controllers\Admin\SettingController::class, 'index'])->name('settings.index');
    Route::post('/setting', [App\Http\Controllers\Admin\SettingController::class, 'update'])->name('settings.update');
    Route::get('/setting/counseling', [App\Http\Controllers\Admin\SettingController::class, 'counseling'])->name('settings.counseling');
    Route::post('/setting/counseling', [App\Http\Controllers\Admin\SettingController::class, 'updateCounseling'])->name('settings.counseling.update');
    Route::get('/setting/crypto', [App\Http\Controllers\Admin\SettingController::class, 'crypto'])->name('settings.crypto');
    Route::post('/setting/crypto', [App\Http\Controllers\Admin\SettingController::class, 'updateCrypto'])->name('settings.crypto.update');
    Route::get('/setting/sliders', [App\Http\Controllers\Admin\SettingController::class, 'sliders'])->name('settings.sliders');
    Route::post('/setting/sliders', [App\Http\Controllers\Admin\SettingController::class, 'updateSliders'])->name('settings.sliders.update');
    Route::get('/setting/notices', [App\Http\Controllers\Admin\SettingController::class, 'notices'])->name('settings.notices');
    Route::post('/setting/notices', [App\Http\Controllers\Admin\SettingController::class, 'updateNotices'])->name('settings.notices.update');
    Route::get('/setting/satisfaction', [App\Http\Controllers\Admin\SettingController::class, 'satisfaction'])->name('settings.satisfaction');
    Route::post('/setting/satisfaction', [App\Http\Controllers\Admin\SettingController::class, 'updateSatisfaction'])->name('settings.satisfaction.update');
    Route::get('/setting/subscriptions', [App\Http\Controllers\Admin\SettingController::class, 'subscriptions'])->name('settings.subscriptions');
    Route::post('/setting/subscriptions', [App\Http\Controllers\Admin\SettingController::class, 'updateSubscriptions'])->name('settings.subscriptions.update');
    Route::get('/setting/appearance', [App\Http\Controllers\Admin\SettingController::class, 'appearance'])->name('settings.appearance');
    Route::post('/setting/appearance', [App\Http\Controllers\Admin\SettingController::class, 'updateAppearance'])->name('settings.appearance.update');
});
