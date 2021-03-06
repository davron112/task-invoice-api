<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group([
    'prefix'    => 'invoices'
], function () {
    Route::get('/', [\App\Http\Controllers\InvoicesController::class, 'getAll']);
    Route::post('/create', [\App\Http\Controllers\InvoicesController::class, 'create']);
    Route::post('/link/{link}', [\App\Http\Controllers\InvoicesController::class, 'show']);
    Route::post('/send', [\App\Http\Controllers\InvoicesController::class, 'send']);
});

Route::group([
    'prefix'    => 'payments'
], function () {
    Route::get('/', [\App\Http\Controllers\PaymentsController::class, 'getAll']);
    Route::post('/create', [\App\Http\Controllers\PaymentsController::class, 'addPayment']);
});

Route::group([
    'prefix'    => 'users'
], function () {
    Route::get('/', [\App\Http\Controllers\UsersController::class, 'getAll']);
    Route::post('/create', [\App\Http\Controllers\UsersController::class, 'create']);
});
