<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\FlashcardController;
use App\Http\Controllers\ListWordController;
use App\Http\Controllers\GrammarController;
use App\Http\Controllers\HomeController;

// ✅ Authentication & Email Verification
Auth::routes(['verify' => true]);

// ✅ Home (chỉ truy cập nếu đã login và xác minh email)
Route::get('/home', [HomeController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('home');

// ✅ Đăng ký
// Route::get('/signin', [AccountController::class, 'signin'])->name('sign_in_view');
// Route::post('/signin', [AccountController::class, 'handleSignin'])->name('sign_in');

// ✅ Quên mật khẩu
// Route::get('/forgot_password', [AccountController::class, 'forgot_pasword'])->name('forgot_pasword');
// Route::post('/verify_email', [AccountController::class, 'verify_email'])->name('verify_email');
// Route::post('/forgot-password', [AccountController::class, 'sendResetLinkEmail'])->name('password-email');
// Route::get('/reset-password', [AccountController::class, 'showResetForm'])->name('password.reset');
// Route::post('/reset-password', [AccountController::class, 'handleResetPassword'])->name('password-update');

// ✅ Thay đổi mật khẩu (phải đăng nhập)
// Route::middleware('auth')->group(function () {
//     Route::get('/change-password', [AccountController::class, 'change_password'])->name('change_password');
//     Route::post('/change-password-handle', [AccountController::class, 'handleChange_password'])->name('handle_change_password');
// });

// ✅ Flashcard
Route::middleware(['auth', 'verified'])->prefix('flashcard')->group(function () {
    Route::post('/delete/{id}', [FlashcardController::class, 'delete'])->name('delete');
    Route::post('/add', [FlashcardController::class, 'create'])->name('create');
    Route::get('/detail/{id}', [FlashcardController::class, 'detail'])->name('detail');
    Route::post('/edit/{id}', [FlashcardController::class, 'edit'])->name('edit');
    Route::get('/list/{list_id}', [FlashcardController::class, 'showByList'])->name('index');
    Route::get('/search', [FlashcardController::class, 'search'])->name('search');
});

// ✅ Danh sách từ vựng

Route::middleware(['auth', 'verified'])->prefix('list_word')->group(function () {
    Route::get('/', [ListWordController::class, 'index'])->name('list-word');
    Route::post('/add', [ListWordController::class, 'store'])->name('add');
    Route::post('/edit/{id}', [ListWordController::class, 'edit'])->name('edit_list');
    Route::get('/search', [ListWordController::class, 'search_list'])->name('search_list');
    Route::post('/delete', [ListWordController::class, 'delete'])->name('delete_list');
});

// ✅ Practice + Ngữ pháp
Route::middleware(['auth', 'verified'])->prefix('practice')->group(function () {
    Route::get('/', [ListWordController::class, 'practice_index'])->name('practice_index');
    Route::get('/search', [ListWordController::class, 'search_all'])->name('search_all');
    Route::get('/grammar', [GrammarController::class, 'index'])->name('grammar_index');
});
Route::middleware(['auth', 'verified'])->prefix('profile')->group(function () {
    Route::get('/', [AccountController::class, 'index'])->name('profile');
    Route::post('/edit-info', [AccountController::class, 'edit_infor'])->name('edit_infor');
});