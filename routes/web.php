<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\GetCarouselController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\CartController;


// Route per la homepage (index.php)
Route::get('/', function () {
    return view('home'); //home.blade.php
})->name('home');

// Route per l'API del carosello
Route::get('/api/carousel-items', [GetCarouselController::class, 'getCarouselItems'])->name('api.carousel.items');

// Route per la pagina dello shop 
Route::get('/shop', [ShopController::class, 'index'])->name('shop');

Route::get('/team', function () {
    return view('team'); // Restituisce la vista team.blade.php
})->name('team');

// Route API per ottenere i prodotti
Route::get('/api/products', [ShopController::class, 'getProducts'])->name('api.products');

// Route API per aggiungere al carrello
Route::post('/api/cart/add', [CartController::class, 'addToCart'])->name('api.cart.add');

// Route per mostrare il form di login
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');

// Route per elaborare la richiesta di login (POST)
Route::post('/login', [AuthController::class, 'loginProcess']); 

Route::post('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/');
})->name('logout');

// Route per mostrare il form di registrazione
Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');

// Route per elaborare la richiesta di registrazione (POST)
Route::post('/register', [AuthController::class, 'registerProcess']);

Route::get('/cart', function () {
    return view('cart'); // Restituisce la vista cart.blade.php
})->name('cart');

Route::post('/api/cart/add', [CartController::class, 'addToCart']);
Route::post('/api/cart/remove', [CartController::class, 'removeCartItem']);
Route::post('/api/cart/update-quantity', [CartController::class, 'updateCartItemQuantity']);
Route::get('/api/cart-items', [CartController::class, 'getCartItems']);

// Route per Unsplash (chiamate GET)
Route::get('/unsplash-images', [ApiController::class, 'getUnsplashImages']);

// Route per ChatGPT (chiamate POST)
Route::post('/chatgpt-message', [ApiController::class, 'sendChatGPTMessage']);