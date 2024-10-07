<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;

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
Route::group(['prefix'=> 'v1'], function() {
    Route::post('/auth', [ApiController::class, 'authUser']);
    Route::post('/check-balance', [ApiController::class, 'checkBalance']);
    Route::post('/get-transactions', [ApiController::class, 'getTransactions']);
    Route::post('/find-user', [ApiController::class, 'findUser']);
    Route::post('/send-funds', [ApiController::class, 'sendFunds']);
    Route::post('/my-profile', [ApiController::class, 'myProfile']);
    Route::post('/find-transaction', [ApiController::class, 'findTransaction']);
    Route::post('/generate-payment-link', [ApiController::class, 'generatePaymentLink']);
});
