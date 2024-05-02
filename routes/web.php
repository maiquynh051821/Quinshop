<?php

use App\Http\Controllers\Admin\MainController;
use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\Admin\UploadController;
use App\Http\Controllers\Login\LoginController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Login\GoogleLoginController;
use App\Http\Controllers\User\HomeController;
use App\Http\Controllers\Register\RegisterController;
use App\Models\Admin\Product;

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
  
    Route::get('user/home',[HomeController::class,'index'])->name('user');
    Route::prefix('admin')->group(function () {
        Route::get('home',[MainController::class,'index'])->name('admin');

        #Menu
        Route::prefix('menus')->group(function () {
           Route::get('add',[MenuController::class,'create']);
           Route::post('add',[MenuController::class,'store']);
           Route::get('list',[MenuController::class,'index']);
           Route::get('edit/{menu}',[MenuController::class,'show']);
           Route::post('edit/{menu}',[MenuController::class,'update']);
           Route::delete('destroy',[MenuController::class,'destroy']);
    });

        #Product
        Route::prefix('products')->group(function(){
            Route::get('add',[ProductController::class,'create']); 
            Route::post('add',[ProductController::class,'store']);
            Route::get('list',[ProductController::class,'index']);
            Route::get('edit/{product}',[ProductController::class,'show']);
            Route::post('edit/{product}',[ProductController::class,'update']);
            Route::delete('destroy',[ProductController::class,'destroy']);
        });
        #Slider
        Route::prefix('sliders')->group(function(){
            Route::get('add',[SliderController::class,'create']); 
            Route::post('add',[SliderController::class,'store']);
            Route::get('list',[SliderController::class,'index']);
            Route::get('edit/{slider}',[SliderController::class,'show']);
            Route::post('edit/{slider}',[SliderController::class,'update']);
            Route::delete('destroy',[SliderController::class,'destroy']);
        });

        #Upload
        Route::post('upload/services',[UploadController::class,'store']);
});
});
Route::get('login',[LoginController::class,'index'])->name('login');
Route::post('login/store',[LoginController::class,'store']);
Route::get('register',[RegisterController::class,'index'])->name('register');
Route::post('/register/store',[RegisterController::class,'store']);

// GoogleLoginController redirect and callback urls
Route::get('login/google', [GoogleLoginController::class, 'redirectToGoogle']);
Route::get('login/google/callback', [GoogleLoginController::class, 'handleGoogleCallback']);