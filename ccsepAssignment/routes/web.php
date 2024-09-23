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
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'secureLogin']);

// Home route (for authenticated users)
Route::get('/home', [HomeController::class, 'index'])->name('home');

// Logout route
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| Vulnerable Web Routes
|--------------------------------------------------------------------------
*/

// Vulnerable login routes
Route::get('/vulnerable-login', [LoginController::class, 'showVulnerableLoginForm'])->name('vulnerable-login');
Route::post('/vulnerable-login', [LoginController::class, 'vulnerableLogin']);
