<?php
use Illuminate\LoginController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('index');
});

Route::middleware('web')->group(function () {
    Route::get('/dashboard', function () {
        return view('dash');
    });
});
Route::get('/Login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('/Login', 'Auth\LoginController@login');
Route::get('/signup', 'Auth\RegisterController@showRegistrationForm')->name('signup');
Route::post('/signup', 'Auth\RegisterController@register')->name('signup')->middleware('web');