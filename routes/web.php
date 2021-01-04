<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\NotificationController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/dashboard', [PostController::class, 'getDashboard', Authenticate::class, 'redirectTo'])->middleware('auth')->name('dashboard');

Route::get('/delete-post/{post_id}', [PostController::class, 'getDeletePost'])->middleware('auth')->name('delete-post');

Route::post('/createpost', [PostController::class, 'postCreatePost'])->middleware('auth');
  
Route::post('/edit', [PostController::class, 'postEditPost'])->name('edit')->middleware('auth');

Route::post('/like', [PostController::class, 'postLikePost'])->name('like')->middleware('auth');

Route::post('/comment', [PostController::class, 'postCreateComment'])->middleware('auth')->name('comment');

Route::post('/notification', [NotificationController:: class, 'get'])->middleware('auth')->name('notification');