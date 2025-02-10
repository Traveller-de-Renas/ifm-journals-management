<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\JournalController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\AuthenticationController;

// Route::get('/', function () {
//     return view('welcome');
// });

// Route::middleware([
//     'auth:sanctum',
//     config('jetstream.auth_session'),
//     'verified',
// ])->group(function () {
//     Route::get('/dashboard', function () {
//         return view('dashboard');
//     })->name('dashboard');
// });
Route::get('/', [FrontendController::class, 'index']);

Route::get('/admin', [AuthenticationController::class, 'admin'])->name('admin');
Route::get('/login/{journal?}', [AuthenticationController::class, 'login'])
    ->name('login');
Route::get('/register/{journal?}', [AuthenticationController::class, 'register'])
    ->name('register');
Route::post('/logout/{journal?}', [AuthenticationController::class, 'logout'])
    ->name('logout');


Route::group(['prefix' => 'journals', 'middleware' => 'auth'], function () {
    Route::get('/home', [JournalController::class, 'home'])->name('journals.home');
    Route::get('/index', [JournalController::class, 'index'])->name('journals.index');
    Route::get('/create/{journal?}', [JournalController::class, 'create'])->name('journals.create');
    Route::get('/subjects', [JournalController::class, 'subjects'])->name('journals.subjects');
    Route::get('/categories', [JournalController::class, 'categories'])->name('journals.categories');
    Route::get('/review_messages', [JournalController::class, 'review_messages'])->name('journals.review_messages');
    Route::get('/review_sections', [JournalController::class, 'review_sections'])->name('journals.review_sections');
    Route::get('/file_categories', [JournalController::class, 'file_categories'])->name('journals.file_categories');
    Route::get('/submission_confirmations', [JournalController::class, 'submission_confirmations'])->name('journals.submission_confirmations');

    Route::get('/detail/{journal?}', [JournalController::class, 'detail'])->name('journals.detail');
    Route::get('/submission/{journal?}/{article?}', [JournalController::class, 'submission'])->name('journals.submission');
    Route::get('/submission_download/{article?}', [FrontendController::class, 'submission_download'])->name('journals.submission_download');

    Route::get('/article/{article?}', [JournalController::class, 'article'])->name('journals.article');
    Route::get('/articles/{journal?}/{status?}', [JournalController::class, 'articles'])->name('journals.articles');
    Route::get('/publication/{journal?}', [JournalController::class, 'publication'])->name('journals.publication');
    Route::get('/reviewer/{journal?}', [JournalController::class, 'reviewers'])->name('journals.reviewer');
    Route::get('/team/{journal?}', [JournalController::class, 'team'])->name('journals.team');

    Route::get('/call_for_papers/{journal?}', [JournalController::class, 'call_for_papers'])->name('journals.call_for_papers');
    Route::get('/sliding_images', [FrontendController::class, 'sliding_images'])->name('journals.sliding_images');
});


Route::group(['prefix' => 'users', 'middleware' => 'auth'], function () {
    Route::get('/index', [UserController::class, 'index'])->name('admin.users');
    Route::get('/logs', [UserController::class, 'logs'])->name('admin.user_logs');
    Route::get('/salutations', [UserController::class, 'salutations'])->name('admin.salutations');
    Route::get('/roles', [UserController::class, 'roles'])->name('admin.roles');
    Route::get('/permissions', [UserController::class, 'permissions'])->name('admin.permissions');
});


Route::group(['prefix' => 'journal'], function () {
    Route::get('/viewall', [FrontendController::class, 'viewall'])->name('journal.viewall');
    Route::get('/detail/{journal}', [FrontendController::class, 'journal_detail'])->name('journal.detail');
    Route::get('/articles/{issue}', [FrontendController::class, 'journal_articles'])->name('journal.articles');
    Route::get('/editorial/{issue}', [FrontendController::class, 'journal_editorial'])->name('journal.editorial');
    Route::get('/editorial_download/{issue?}', [FrontendController::class, 'editorial_download'])->name('journal.editorial_download');
    Route::get('/article/{article}', [FrontendController::class, 'journal_article'])->name('journal.article');
    Route::get('/callfor_paper', [FrontendController::class, 'callfor_paper'])->name('journal.callfor_paper');
    Route::get('/call_detail/{call}', [FrontendController::class, 'call_detail'])->name('journal.call_detail');
    Route::get('/archive/{journal}', [FrontendController::class, 'journal_archive'])->name('journal.archive');
    Route::get('/article_download/{article?}', [FrontendController::class, 'article_download'])->name('journal.article_download');
    Route::get('/article_evaluation/{article}/{reviewer}', [JournalController::class, 'article_evaluation'])->name('journal.article_evaluation');
});