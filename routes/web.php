<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SubmitDocumentController;
use App\Http\Controllers\RecordsController;
use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\DocumentController;

Route::get('/', function () {
    return view('index');
});

Route::get('/admindashboard', function () {
    return view('admindash');
})->name('admindashboard');

Route::middleware('web')->group(function () {
    Route::get('/dashboard', function () {
        return view('dash');
    });
    
    // Routes requiring authentication
    Route::middleware('web')->group(function () {
        Route::get('/submit-document', [SubmitDocumentController::class, 'showSubmitForm'])->name('submitDocument');
        Route::post('/submit-document', [SubmitDocumentController::class, 'submit'])->name('submitDocument');
        Route::get('/records', [RecordsController::class, 'showRecords'])->name('records');
        Route::get('/document/{filename}', [RecordsController::class, 'view'])->name('documents.view');
        Route::get('/dashboard', [RecordsController::class, 'dashboard'])->name('dashboard');
        Route::post('/archive-documents', [RecordsController::class, 'archiveDocuments'])->name('documents.archive');
        Route::get('/archive', [RecordsController::class, 'showArchive'])->name('archive');
        Route::get('/submit-announcement', [AnnouncementController::class, 'showSubmitForm'])->name('submitAnnouncement');
        Route::post('/submit-announcement', [AnnouncementController::class, 'submit'])->name('submitAnnouncement');
        Route::get('/admindashboard', [RecordsController::class, 'adminDashboard'])->name('admindashboard');



        
    });
});

// Authentication routes
Route::get('/login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('/login', 'Auth\LoginController@login');
Route::get('/signup', 'Auth\RegisterController@showRegistrationForm')->name('signup');
Route::post('/signup', 'Auth\RegisterController@register')->name('signup');

//Document Status Update
Route::post('/documents/{document}/status', [RecordsController::class, 'updateStatus'])->name('documents.updateStatus');

//Document Approval
Route::get('/documents/approve', [DocumentController::class, 'approve'])->name('documents.approve');
Route::get('/documents/disapprove', [DocumentController::class, 'disapprove'])->name('documents.disapprove');

