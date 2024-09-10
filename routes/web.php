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
    Route::get('/form/{journal}', [JournalController::class, 'form'])->name('journals.form');
    Route::get('/subjects', [JournalController::class, 'subjects'])->name('journals.subjects');
    Route::get('/categories', [JournalController::class, 'categories'])->name('journals.categories');
    Route::get('/details/{journal}', [JournalController::class, 'details'])->name('journals.details');
    Route::get('/submission/{journal}/{article?}', [JournalController::class, 'submission'])->name('journals.submission');
    Route::get('/articles/{journal}', [JournalController::class, 'articles'])->name('journals.articles');
    Route::get('/article/{article}', [JournalController::class, 'article'])->name('journals.article');
    Route::get('/article_evaluation/{article}/{reviewer}', [JournalController::class, 'article_evaluation'])->name('journals.article_evaluation');
    Route::get('/archive/{journal}', [JournalController::class, 'archive'])->name('journals.archive');
});


Route::group(['prefix' => 'journal'], function () {
    Route::get('/viewall', [JournalController::class, 'viewall'])->name('journal.viewall');
    Route::get('/detail/{journal}', [JournalController::class, 'journal_detail'])->name('journal.detail');
    Route::get('/articles/{journal}', [JournalController::class, 'journal_articles'])->name('journal.articles');
    Route::get('/article/{article}', [JournalController::class, 'journal_article'])->name('journal.article');
    Route::get('/archive/{journal}', [JournalController::class, 'journal_archive'])->name('journal.archive');
});


Route::group(['prefix' => 'configurations', 'middleware' => 'auth'], function () {
    Route::get('/salutations', [ConfigurationController::class, 'salutations'])->name('admin.salutations');
    Route::get('/review_sections', [ConfigurationController::class, 'review_sections'])->name('admin.review_sections');
    Route::get('/roles', [ConfigurationController::class, 'roles'])->name('admin.roles');
    Route::get('/permissions', [ConfigurationController::class, 'permissions'])->name('admin.permissions');
    Route::get('/staff_list', [ConfigurationController::class, 'staff_list'])->name('admin.staff_list');
});

Route::group(['prefix' => 'users', 'middleware' => 'auth'], function () {
    Route::get('/index', [UserController::class, 'index'])->name('admin.users');
    Route::get('/logs', [UserController::class, 'logs'])->name('admin.logs');
    Route::get('/profile', [UserController::class, 'profile'])->name('admin.profile');
    Route::get('/user_preview/{user?}', [UserController::class, 'user_preview'])->name('admin.user_preview');
});

Route::group(['prefix' => 'website', 'middleware' => 'auth'], function () {
    Route::get('/sliding_images', [WebsiteController::class, 'sliding_images'])->name('admin.sliding_images');
    Route::get('/social_medias', [WebsiteController::class, 'social_medias'])->name('admin.social_medias');
    Route::get('/contacts', [WebsiteController::class, 'contacts'])->name('admin.contacts');
});