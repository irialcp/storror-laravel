<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\GetCarouselController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ApiController;

// Diversa dalla route per le api o che usano controller perché usa direttamente una closure
// (cos'è una closure? una closure è una funzione anonima che può essere usata per definire una route direttamente senza un controller)
Route::get('/', function () {
    return view('home'); //home.blade.php
})->name('home');

Route::get('/api/carousel-items', [GetCarouselController::class, 'getCarouselItems'])->name('api.carousel.items');
// uso direttamente la route del controller dello shop dato che non è una pagina semplice ma una pagina dinamica che mostra i prodotti
Route::get('/shop', [ShopController::class, 'index'])->name('shop');

Route::get('/team', function () {
    return view('team');
})->name('team');

Route::get('/api/products', [ShopController::class, 'getProducts'])->name('api.products');

Route::post('/api/cart/add', [CartController::class, 'addToCart'])->name('api.cart.add');

// Route per mostrare il form di login
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');

// Route per elaborare la richiesta di login (POST)
Route::post('/login', [AuthController::class, 'loginProcess']); 

// route per il logut diversa da quella di login perché non usa un controller ma una closure
// In questa route si fa il logout dell'utente, si invalida la sessione e si rigenera il token 
// CSRF per prevenire attacchi CSRF
// Dopo il logout, l'utente viene reindirizzato alla home page
Route::post('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/');
})->name('logout');

// Route per mostrare il form di registrazione
Route::get('/signin', [AuthController::class, 'showSigninForm'])->name('register');

// Route per elaborare la richiesta di registrazione (POST) si usa post perché si inviano dati al server
// Questa route chiama il metodo signinProcess del controller AuthController
// che si occupa di validare i dati, creare un nuovo utente e gestire l'autenticazione
// Dopo la registrazione, l'utente viene reindirizzato alla pagina dello shop
// e viene effettuato il login automatico
Route::post('/signin', [AuthController::class, 'signinProcess']);

Route::get('/cart', function () {
    return view('cart'); // Restituisce la vista cart.blade.php
})->name('cart');

Route::post('/api/cart/add', [CartController::class, 'addToCart']);
Route::post('/api/cart/remove', [CartController::class, 'removeCartItem']);
Route::post('/api/cart/update-quantity', [CartController::class, 'updateCartItemQuantity']);
Route::get('/api/cart-items', [CartController::class, 'getCartItems']);

// API Routes for external services
Route::get('/api/unsplash-images', [ApiController::class, 'getUnsplashImages'])->name('api.unsplash.images');
Route::post('/api/chatgpt-message', [ApiController::class, 'sendChatGPTMessage'])->name('api.chatgpt.message')->middleware('throttle:3,1');
