<?php

use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\Admin\HomeController;
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

// * Route for guests only
Route::group(['middleware' => ['guest:web']], function () {
    Route::get('/admin/login', function () {
        return view('auth.login');
    });
    Route::post('/admin/login', [LoginController::class, 'adminLogin'])->name('admin.login');
});

Route::group(['middleware' => ['admin:web']], function () {
    Route::get('admin/home', [HomeController::class, 'index'])->name('home');
    Route::post('/admin/logout', [LoginController::class, 'adminLogout'])->name('admin.logout');
});
