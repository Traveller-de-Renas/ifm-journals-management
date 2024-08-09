<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\JournalController;
use App\Http\Controllers\WebsiteController;
use App\Http\Controllers\DataFeedController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ConfigurationController;

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

Route::get('/', [HomeController::class, 'index']);

Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    Route::get('/json-data-feed', [DataFeedController::class, 'getDataFeed'])->name('json_data_feed');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});



Route::group(['prefix' => 'journals', 'middleware' => 'auth'], function () {
    Route::get('/index', [JournalController::class, 'index'])->name('journals.index');
    Route::get('/subjects', [JournalController::class, 'subjects'])->name('journals.subjects');
    Route::get('/categories', [JournalController::class, 'categories'])->name('journals.categories');
    Route::get('/details{journal}', [JournalController::class, 'details'])->name('journals.details');
    Route::get('/submission{journal}', [JournalController::class, 'submission'])->name('journals.submission');
});

Route::group(['prefix' => 'configurations', 'middleware' => 'auth'], function () {
    Route::get('/salutations', [ConfigurationController::class, 'salutations'])->name('admin.salutations');
    Route::get('/roles', [ConfigurationController::class, 'roles'])->name('admin.roles');
    Route::get('/permissions', [ConfigurationController::class, 'permissions'])->name('admin.permissions');
});

Route::group(['prefix' => 'users', 'middleware' => 'auth'], function () {
    Route::get('/index', [UserController::class, 'index'])->name('admin.users');
    Route::get('/logs', [UserController::class, 'logs'])->name('admin.logs');
});

Route::group(['prefix' => 'website', 'middleware' => 'auth'], function () {
    Route::get('/sliding_images', [WebsiteController::class, 'sliding_images'])->name('admin.sliding_images');
    Route::get('/social_medias', [WebsiteController::class, 'social_medias'])->name('admin.social_medias');
    Route::get('/contacts', [WebsiteController::class, 'contacts'])->name('admin.contacts');
});