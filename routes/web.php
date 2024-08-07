<?php

use App\Http\Controllers\Admin\CartController;
use App\Http\Controllers\Admin\MainController;
use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\Admin\FooterController;
use App\Http\Controllers\Admin\UploadController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\SiteInfoController;
use App\Http\Controllers\Admin\AdminContactController;
use App\Http\Controllers\Login\LoginController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Login\GoogleLoginController;
use App\Http\Controllers\User\MainshopController;
use App\Http\Controllers\Register\RegisterController;
use App\Http\Controllers\User\CartshopController;
use App\Http\Controllers\User\MenushopController;
use App\Http\Controllers\User\ProductshopController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\SuccessController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\DashboardController;


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
Route::middleware(['admin'])->group(function () {

    Route::prefix('admin')->group(function () {
        // Route::get('dashboard', [DashboardController::class, 'index'])->name('admin');

        #Menu
        Route::prefix('menus')->group(function () {
            Route::get('add', [MenuController::class, 'create']);
            Route::post('add', [MenuController::class, 'store']);
            Route::get('list', [MenuController::class, 'index']);
            Route::get('edit/{menu}', [MenuController::class, 'show']);
            Route::post('edit/{menu}', [MenuController::class, 'update']);
            Route::delete('destroy', [MenuController::class, 'destroy']);
        });

        #Product
        Route::prefix('products')->group(function () {
            Route::get('add', [ProductController::class, 'create']);
            Route::post('store_product', [ProductController::class, 'store_product'])->name('store_product');
            Route::get('list', [ProductController::class, 'index'])->name('list_product');
            Route::get('quan-ly-comment', [ProductController::class, 'comment'])->name('quanly_comment');
            Route::get('list-comment', [ProductController::class, 'list_comment'])->name('list_comment');
            Route::get('status_comment/{id}', [ProductController::class, 'status_comment'])->name('status_comment');
            Route::get('chi-tiet-comment/{id}', [ProductController::class, 'delatilcomment'])->name('delatil_comment');
            Route::get('edit-comment/{id}', [ProductController::class, 'editcomment'])->name('edit_comment');
            Route::get('edit/{product}', [ProductController::class, 'show']);
            Route::post('update_product', [ProductController::class, 'update_product'])->name('update_product');
            Route::get('destroy', [ProductController::class, 'destroy'])->name('product.destroy');
            Route::get('search_product', [ProductController::class, 'search'])->name('search_product');
        });
        #Slider
        Route::prefix('sliders')->group(function () {
            Route::get('add', [SliderController::class, 'create']);
            Route::post('add', [SliderController::class, 'store']);
            Route::get('list', [SliderController::class, 'index']);
            Route::get('edit/{slider}', [SliderController::class, 'show']);
            Route::post('update_slider', [SliderController::class, 'update'])->name('update_slider');
            Route::delete('destroy', [SliderController::class, 'destroy']);
        });

        #Upload
        Route::post('upload/services', [UploadController::class, 'store']);

        #Cart
        Route::get('customers', [CartController::class, 'index']);
        Route::get('customers/view/{customer}', [CartController::class, 'show']);
        Route::get('cart_status', [CartController::class, 'cartStatus'])->name('cart_status');

        #Tai khoan
        Route::prefix('users')->group(function () {
            Route::get('list', [UserController::class, 'index']);
            Route::get('edit/{user}', [UserController::class, 'show']);
            Route::post('edit/{user}', [UserController::class, 'update']);
            Route::delete('destroy', [UserController::class, 'destroy']);
            Route::get('search_user', [UserController::class, 'search'])->name('search_user');
        });

        #Footer
        Route::prefix('footers')->group(function () {
            Route::get('add', [FooterController::class, 'create']);
            Route::post('add', [FooterController::class, 'store']);
            Route::get('list', [FooterController::class, 'index'])->name('admin.footer.list');
            Route::get('edit/{footer}', [FooterController::class, 'show']);
            Route::post('edit/{footer}', [FooterController::class, 'update']);
            Route::delete('destroy', [FooterController::class, 'destroy']);
        });

        #SiteInfo
        Route::prefix('siteInfos')->group(function () {
            Route::get('list', [SiteInfoController::class, 'index'])->name('admin.site_info.list');
            Route::get('edit/{siteInfo}', [SiteInfoController::class, 'show']);
            Route::post('edit/{siteInfo}', [SiteInfoController::class, 'update']);
            Route::delete('destroy', [SiteInfoController::class, 'destroy']);
        });
        #Contact
        Route::prefix('contacts')->name('admin.')->group(function () {
            Route::get('list', [AdminContactController::class, 'index'])->name('contacts.list');
            Route::put('/{id}/update-status', [AdminContactController::class, 'updateStatus'])->name('contacts.updateStatus');
            Route::get('contacts/{id}', [AdminContactController::class, 'show'])->name('contacts.show');
            Route::post('contacts/{id}/send-reply', [AdminContactController::class, 'sendReply'])->name('contacts.sendReply');
        });
        #Dashboard
        Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    });
});

Route::get('login', [LoginController::class, 'index'])->name('login');
Route::get('forget_password', [LoginController::class, 'forget_password'])->name('forget_password');
Route::get('check_email', [LoginController::class, 'check_email'])->name('check_email');
Route::get('reset_password', [LoginController::class, 'reset_password'])->name('reset_password');
Route::post('login/store', [LoginController::class, 'store']);
Route::get('register', [RegisterController::class, 'index'])->name('register');
Route::post('/register/store', [RegisterController::class, 'store']);

// GoogleLoginController redirect and callback urls
Route::get('login/google', [GoogleLoginController::class, 'redirectToGoogle']);
Route::get('login/google/callback', [GoogleLoginController::class, 'handleGoogleCallback']);


Route::middleware(['auth'])->group(function () {

    // Route::get('user/home',[MainshopController::class,'index'])->name('user');
    #Trang dat hang
    Route::get('checkouts', [CartshopController::class, 'showCheckout'])->name('user');
    Route::post('/products/{product}/like', [ProductshopController::class, 'like'])->name('products.like');
    Route::post('/products/{product}/unlike', [ProductshopController::class, 'unlike'])->name('products.unlike');
    Route::get('/likes', [ProductshopController::class, 'show']);
   

    // pay os
    Route::get('/nap-tien', [CheckoutController::class, 'index'])->name('package.index');
    Route::get('/success', [SuccessController::class, 'successPayment']);
    Route::get('/cancel', [SuccessController::class, 'cancelPayment']);
    Route::post('createPaymentLink', [CheckoutController::class, 'createPaymentLink'])->name('createPaymentLink');

    Route::prefix('/order')->group(function () {
        Route::post('/create', [OrderController::class, 'createOrder']);
        Route::get('/{id}', [OrderController::class, 'getPaymentLinkInfoOfOrder']);
        Route::put('/{id}', [OrderController::class, 'cancelPaymentLinkOfOrder']);
    });

    Route::prefix('/payment')->group(function () {
        Route::post('/payos', [PaymentController::class, 'handlePayOSWebhook']);
    });
    // end pay os
    Route::get('/san-pham-vua-mua/{customer_id}', [CartshopController::class, 'cartList'])->name('cart_list');
    Route::get('/san-pham-cua-ban', [CartshopController::class, 'cartListUser'])->name('cart_list_user');
    Route::get('danh-gia-san-pham', [CartshopController::class, 'comment'])->name('comment');
    Route::get('disCart/{id}', [CartshopController::class, 'disCart'])->name('disCart');
});

Route::get('/', [MainshopController::class, 'index'])->name('home');
Route::post('/services/load-product', [MainshopController::class, 'loadProduct']);
Route::get('danh-muc/{id}-{slug}.html', [MenushopController::class, 'index']);
Route::get('san-pham/{id}-{slug}.html', [ProductshopController::class, 'index']);
Route::post('add-cart', [CartshopController::class, 'index']);
Route::get('carts', [CartshopController::class, 'show']);
Route::get('search_carts', [CartController::class, 'search_carts'])->name('search_carts');
Route::post('/update-cart', [CartshopController::class, 'update']);
Route::post('/remove-cart', [CartshopController::class, 'remove'])->name('cart.remove');
Route::get('/search', [ProductshopController::class, 'search'])->name('search');
Route::get('/search_comment', [ProductshopController::class, 'search_comment'])->name('search_comment');
Route::get('/footer/{id}', [MainshopController::class, 'footerContent'])->name('footers.show');
Route::get('/contact', [ContactController::class, 'show'])->name('contact.form');
Route::post('/contact', [ContactController::class, 'submit'])->name('contact.submit');
Route::get('/trending', [ProductshopController::class, 'getLikeMax'])->name('trending');