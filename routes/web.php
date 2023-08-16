<?php

use App\Http\Controllers\CompanyController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\MeetingController;
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


// Company All Route --------------------------------------------------------------------------------
Route::get('/', [CompanyController::class, 'CompanyIndex'])->name('company');
Route::post('/store', [CompanyController::class, 'CompanyStore'])->name('store');
Route::get('/fetchAll', [CompanyController::class, 'CompanyFetchAll'])->name('fetchAll');
Route::get('/edit', [CompanyController::class, 'CompanyEdit'])->name('edit');
Route::post('/update', [CompanyController::class, 'CompanyUpdate'])->name('update');
Route::delete('/delete', [CompanyController::class, 'CompanyDelete'])->name('delete');


// Contact All Route --------------------------------------------------------------------------------
Route::get('/contact', [ContactController::class, 'ContactIndex'])->name('contact');
Route::post('/contact/store', [ContactController::class, 'ContactStore'])->name('contact.store');
Route::get('/contact/fetchAll', [ContactController::class, 'ContactFetchAll'])->name('contact.fetchAll');
Route::get('/contact/edit', [ContactController::class, 'ContactEdit'])->name('contact.edit');
Route::post('/contact/update', [ContactController::class, 'ContactUpdate'])->name('contact.update');
Route::delete('/contact/delete', [ContactController::class, 'ContactDelete'])->name('contact.delete');

// Meeting All Route --------------------------------------------------------------------------------
Route::get('/meeting', [MeetingController::class, 'MeetingIndex'])->name('meeting');
Route::post('/meeting/store', [MeetingController::class, 'MeetingStore'])->name('meeting.store');
Route::get('/meeting/fetchAll', [MeetingController::class, 'MeetingFetchAll'])->name('meeting.fetchAll');
Route::get('/meeting/edit', [MeetingController::class, 'MeetingEdit'])->name('meeting.edit');
Route::post('/meeting/update', [MeetingController::class, 'MeetingUpdate'])->name('meeting.update');
Route::delete('/meeting/delete', [MeetingController::class, 'MeetingDelete'])->name('meeting.delete');
