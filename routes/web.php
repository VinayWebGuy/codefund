<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InnerController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\DepositController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\FriendsController;

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


Route::get('/', [HomeController::class, 'index']);
Route::get('login', [HomeController::class, 'login'])->name('login');
Route::get('register', [HomeController::class, 'register']);
Route::get('forget-password', [HomeController::class, 'forgetPassword']);
Route::get('reset-password', [HomeController::class, 'resetPassword']);
Route::get('otp', [HomeController::class, 'otp']);

Route::post('register', [AuthController::class, 'registerUser'])->name('user.register');
Route::post('login', [AuthController::class, 'authUser'])->name('user.auth');
Route::get('logout', [AuthController::class, 'logout'])->name('user.logout');

Route::group(['prefix'=> 'main', 'middleware' => 'login.auth'], function() {
    Route::get('/', [InnerController::class, 'mainIndex']);
    Route::group(['prefix'=> 'admin', 'middleware' => 'admin.auth'], function() {
        Route::get('/', [InnerController::class, 'adminIndex']);
        Route::get('/profile', [InnerController::class, 'profile']);
        Route::group(['prefix'=> 'deposit'], function() {
            Route::get('/', [DepositController::class, 'addDeposit']);
            Route::post('/', [DepositController::class, 'saveDeposit'])->name('deposit.save');
            Route::get('/all', [DepositController::class, 'allDeposits']);
        });
        Route::group(['prefix'=> 'users'], function() {
            Route::get('/', [InnerController::class, 'allUsers']);
            Route::get('/change-status/{id}', [InnerController::class, 'changeUserStatus']);
        });
    });
    Route::group(['prefix'=> 'user', 'middleware' => 'user.auth'], function() {
        Route::group(['prefix'=> 'api'], function() {
            Route::get('/', [InnerController::class, 'apiManager']);
            Route::get('/usage', [InnerController::class, 'apiUsage']);
            Route::get('/delete/{key}', [ApiController::class, 'deleteApi']);
            Route::get('/edit/{key}', [ApiController::class, 'editApi']);
            Route::get('/change-status/{key}', [ApiController::class, 'changeApiStatus']);
            Route::get('/permission/{key}', [ApiController::class, 'updateApiPermissions']);
            
            Route::post('/update-permission', [ApiController::class, 'savePermissions'])->name('permission.update');
            Route::post('/', [ApiController::class, 'generateApi'])->name('generate.key');
            Route::post('/update', [ApiController::class, 'updateApi'])->name('update.key');
        });
        Route::get('/', [InnerController::class, 'userIndex']);
        Route::get('/profile', [InnerController::class, 'profile']);
        // Route::get('/refer', [InnerController::class, 'refer']);
        Route::get('/create-account', [InnerController::class, 'createAccount']);
        Route::group(['prefix'=> 'funds'], function() {
            Route::get('/add', [InnerController::class, 'addFunds']);
            Route::get('/transfer/{account_number?}', [InnerController::class, 'fundsTransfer']);
            Route::get('/payment-link', [InnerController::class, 'paymentLink']);
            Route::get('/all-payment-links', [InnerController::class, 'allPaymentLinks']);
            Route::get('/pay-via-link/{link}', [DepositController::class, 'payViaLink']);
            Route::post('/add', [DepositController::class, 'addFunds'])->name('funds.add');
            Route::post('/transfer', [DepositController::class, 'fundsTransfer'])->name('funds.transfer');
            Route::post('/payment-link', [DepositController::class, 'generatePaymentLink'])->name('funds.paymentLinkGenerate');
        });
        Route::group(['prefix'=> 'friends'], function() {
            Route::get('/all', [FriendsController::class, 'allFriends']);
            Route::get('/add', [FriendsController::class, 'addFriend']);
            Route::get('/change-status/{id}', [FriendsController::class, 'changeStatus']);
            Route::post('/add', [FriendsController::class, 'saveFriend'])->name('friend.add');
        });
        Route::group(['prefix'=> 'transactions'], function() {
            Route::get('/', [TransactionController::class, 'allTransactions']);
        });
    });
});