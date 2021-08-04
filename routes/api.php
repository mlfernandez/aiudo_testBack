<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\LoanController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PassportAuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PaymentController;

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

    // POST http://localhost:8000/api/register

Route::post('register', [PassportAuthController::class, 'register']);


    // POST http://localhost:8000/api/login

Route::post('login', [PassportAuthController::class, 'login']);

Route::middleware('auth:api')->group(function () {
    
    // USER // 

        // ruta crud completo de user
    Route::resource('users', UserController::class);

        // ruta para que el usuario haga logout
    Route::post('users/logout', [UserController::class,'logout']); 


    // ACCOUNT //

        // POST http://localhost:8000/api/accounts
    Route::resource('accounts', AccountController::class);


    // LOAN //

        // POST http://localhost:8000/api/loans
    Route::resource('loans', LoanController::class);

    // PAYMENT //

        // POST http://localhost:8000/api/payments
    Route::resource('payments', PaymentController::class);

            
        // POST POST http://localhost:8000/api/payments/userid
        // Postman: necestia "token", "id" por body
    Route::post('payments/userid', [PaymentController::class, 'show']);

});
