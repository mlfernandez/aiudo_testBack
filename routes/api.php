<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PassportAuthController;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// POST https://gamechat-laravel-mlf.herokuapp.com/api/register
// Postman: necesita username, email, password y name
Route::post('register', [PassportAuthController::class, 'register']);


// LOGIN POST https://gamechat-laravel-mlf.herokuapp.com/api/login
// Postman: necesita email y password por body
Route::post('login', [PassportAuthController::class, 'login']);

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
