<?php

use App\Http\Controllers\CommentsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::get('/comments', [CommentsController::class, 'index']);
Route::get('/comments/filter', [CommentsController::class, 'filterComments']);
Route::get('/comments/{commentId}/responses', [CommentsController::class, 'loadResponses']);
Route::get('/capcha', [CommentsController::class, 'getCapcha']);
Route::post('/store', [CommentsController::class, 'store']);
Route::delete('/{commentId}/delete', [CommentsController::class, 'delete']);
