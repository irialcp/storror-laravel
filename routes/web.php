<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\GetCarouselController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ApiController;

Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/api/carousel-items', [GetCarouselController::class, 'getCarouselItems'])->name('api.carousel.items');
Route::get('/shop', [ShopController::class, 'index'])->name('shop');

Route::get('/team', function () {
    return view('team');
})->name('team');

Route::get('/api/products', [ShopController::class, 'getProducts'])->name('api.products');

Route::post('/api/cart/add', [CartController::class, 'addToCart'])->name('api.cart.add');

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');

Route::post('/login', [AuthController::class, 'loginProcess']); 

Route::post('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/');
})->name('logout');

Route::get('/signin', [AuthController::class, 'showSigninForm'])->name('signin');

Route::post('/signin', [AuthController::class, 'signinProcess']);

Route::get('/cart', function () {
    return view('cart');
})->name('cart');

Route::post('/api/cart/add', [CartController::class, 'addToCart']);
Route::post('/api/cart/remove', [CartController::class, 'removeCartItem']);
Route::post('/api/cart/update-quantity', [CartController::class, 'updateCartItemQuantity']);
Route::get('/api/cart-items', [CartController::class, 'getCartItems']);

Route::get('/api/unsplash-images', [ApiController::class, 'getUnsplashImages'])->name('api.unsplash.images');
Route::post('/api/chatgpt-message', [ApiController::class, 'sendChatGPTMessage'])->name('api.chatgpt.message')->middleware('throttle:3,1');
