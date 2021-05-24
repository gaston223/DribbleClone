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

//Route group for authenticated users only
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

//Routes for guests only
Route::group(['middleware' => ['auth:api']], function (){

});
Route::group(['middleware' => ['guest:api']], function (){
    //Route::post('register', [A]);
});

Route::get('/', function (){
    return response()->json(['message' => 'Hello World'], 200);
});
