<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SubmitDocumentController;
use App\Http\Controllers\RecordsController;

Route::get('/', function () {
    return view('index');
});

Route::middleware('web')->group(function () {
    Route::get('/dashboard', function () {
        return view('dash');
    });

    // Routes requiring authentication
    Route::middleware('web')->group(function () {
        Route::get('/submit-document', [SubmitDocumentController::class, 'showSubmitForm'])->name('submitDocument');
        Route::post('/submit-document', [SubmitDocumentController::class, 'submit'])->name('submitDocument');
        Route::get('/records', [RecordsController::class, 'showRecords'])->name('records.index');
    });
});

// Authentication routes
Route::get('/login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('/login', 'Auth\LoginController@login');
Route::get('/signup', 'Auth\RegisterController@showRegistrationForm')->name('signup');
Route::post('/signup', 'Auth\RegisterController@register')->name('signup');
