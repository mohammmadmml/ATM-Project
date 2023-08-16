<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\CardController;
use App\Http\Controllers\TransactionController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::middleware('auth:api')->group(function () {
    Route::get('/user/card/info', [CardController::class, 'show_cards']);
    Route::post('/user/create/card', [CardController::class, 'create_card']);
    Route::post('/user/change/card/password', [CardController::class, 'changePassword']);
    Route::post('/user/change/password/{card}', [AuthenticationController::class, 'ChangePassword']);
    Route::post('/user/deposit' , [TransactionController::class, 'deposit'])->middleware('auth:api');
    Route::post('/user/withdraw/', [TransactionController::class, 'withdraw']);
    Route::post('/user/transfer', [TransactionController::class, 'transfer']);
    Route::post('/user/balance' , [CardController::class, 'baaalance']);


});
Route::post('/user/register', [AuthenticationController::class, 'register']);
Route::post('/user/login', [AuthenticationController::class, 'login'])->name('login');

