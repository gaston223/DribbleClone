<?php

use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\Auth\RegisterController;
use App\Http\Controllers\Api\Auth\VerificationController;
use App\Http\Controllers\Api\User\MeController;
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

// * Public routes
Route::get('me', [MeController::class, 'getMe']);

// * Route group for authenticated users only
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// * Routes for guests only
Route::group(['middleware' => ['auth:api']], function (){
    Route::post('logout', [LoginController::class, 'logout']);
});
Route::group(['middleware' => ['guest:api']], function (){
    Route::post('register', [RegisterController::class, 'register']);
    Route::post('verification/verify/{user}', [VerificationController::class, 'verify'])->name('verification.verify');
    Route::post('verification/resend', [VerificationController::class, 'resend']);
    Route::post('login', [LoginController::class, 'login']);
});

Route::get('/', function (){
    return response()->json(['message' => 'Hello World'], 200);
});
