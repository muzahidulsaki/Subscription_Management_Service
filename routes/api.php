<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SubscriptionController;

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

// packages List
Route::get('/packages', [SubscriptionController::class, 'getPackages']);

// Subscribe to a package
Route::post('/subscribe', [SubscriptionController::class, 'subscribe']);

// current subscription status
Route::get('/status/{user_id}', [SubscriptionController::class, 'getStatus']);

// Subscription history
Route::get('/history/{user_id}', [SubscriptionController::class, 'getHistory']);