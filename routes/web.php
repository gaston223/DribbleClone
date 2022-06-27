<?php

use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

//Auth::routes();

Route::get('/admin/login', function (){
    return view('auth.login');
});
Route::post('/admin/login', [LoginController::class, 'login'])->name('show.login.form');
Route::post('/admin/logout',  [LoginController::class, 'logout'])->name('performLogout');

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

