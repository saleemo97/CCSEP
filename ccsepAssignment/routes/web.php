<?php

use Illuminate\Support\Facades\Route;
use App\Models\Post;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/test-mongodb', function () {
    // Insert a new post into MongoDB
    $post = Post::create([
        'title' => 'My First Post',
        'content' => 'This is the content of my first post.',
    ]);

    // Fetch all posts from MongoDB
    $posts = Post::all();

    return $posts;
});
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
