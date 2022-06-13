<?php

use App\Http\Controllers\PostController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\UserController;
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

Route::get('/', fn () => view('root'));

Route::get('/signup', [UserController::class, 'create']);
Route::resource('/user', UserController::class)->only([
    'store'
]);

Route::get('/login', [SessionController::class, 'create'])->name('login');
Route::resource('/session', SessionController::class)->only([
    'store',
    'destroy',
]);

Route::resource('/post', PostController::class)->only([
    'store',
]);
