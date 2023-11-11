<?php

use App\Http\Controllers\AccountController;
use Illuminate\Support\Facades\Route;

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

Route::view('/', 'index')->name('home');
Route::view('/SignIn', 'index')->middleware('user.auth')->name('signin');
Route::view('/LogIn', 'index')->middleware('user.auth')->name('login');

Route::post('/register', [AccountController::class, 'register']);
Route::post('/auth', [AccountController::class, 'authenticate']);
Route::post('/logOut', [AccountController::class, 'logOut']);