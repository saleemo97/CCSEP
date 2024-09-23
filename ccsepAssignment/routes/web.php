<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Authentication routes
Auth::routes();

// Secure login routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login')->middleware('guest');
Route::post('/login', [LoginController::class, 'secureLogin'])->middleware('guest');


// Home route (for authenticated users)
Route::get('/home', [HomeController::class, 'index'])->name('home')->middleware('auth');

// Logout route
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| Vulnerable Web Routes
|--------------------------------------------------------------------------
*/

// Vulnerable login routes
Route::get('/vulnerable-login', [LoginController::class, 'showVulnerableLoginForm'])->name('vulnerable-login')->middleware('guest');
Route::post('/vulnerable-login', [LoginController::class, 'vulnerableLogin'])->middleware('guest');


Route::get('/xss-demo', function () {
    return view('xss-demo');
});

// New route for the fixed XSS demo
Route::get('/xss-demo-fixed', function () {
    return view('xss-demo-fixed');
});
