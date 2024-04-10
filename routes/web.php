<?php

use App\Http\Controllers\Admin\MainController;
use App\Http\Controllers\Login\LoginController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Login\GoogleLoginController;
use App\Http\Controllers\User\HomeController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
#Middleware auth duoc su dung de dam bao rang nguoi dung phai dang nhap 
#de co the truy cap tat ca cac route duoc bao ve boi no
Route::middleware(["auth"])->group(function () {
    Route::get('/admin/home',[MainController::class,'index'])->name('admin');
    Route::get('/user/home',[HomeController::class,'index'])->name('user');
});
Route::get('/login',[LoginController::class,'index'])->name('login');
Route::post('/login/store',[LoginController::class,'store']);

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    // Route::get('/dashboard', function () {
    //     return view('dashboard');
    // })->name('dashboard');
    Route::get('/admin/home',[MainController::class,'index'])->name('admin');
});

// GoogleLoginController redirect and callback urls
Route::get('/login/google', [GoogleLoginController::class, 'redirectToGoogle']);
Route::get('/login/google/callback', [GoogleLoginController::class, 'handleGoogleCallback']);
