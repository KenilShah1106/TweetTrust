<?php

use App\Http\Controllers\RepliesController;
use App\Http\Controllers\Frontend\FrontendRepliesController;
use App\Http\Controllers\Frontend\FrontendTweetsController;
use App\Http\Controllers\Frontend\FrontendTagsController;
use App\Http\Controllers\Frontend\FrontendUsersController;
use App\Http\Controllers\TweetsController;
use App\Http\Controllers\TagsController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\VotesController;
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

Auth::routes();
/* AUTH ROUTES */
Route::middleware(['auth'])->group(function() {

    /* QUESTION */
    Route::resource('tweets', TweetsController::class)->except('show', 'create', 'edit');

    /* TAGS */
    Route::resource('tags', TagsController::class)->except('show', 'create', 'edit');

    /* ANSWER */
    Route::resource('tweets.replies', RepliesController::class)->except('show', 'create', 'edit');
    Route::put('tweets/{tweet}/replies/{answer}/mark-as-best', [TweetsController::class, 'markAsBest'])->name('tweets.replies.markAsBest');

    /* USER */
    Route::resource('users', UsersController::class)->except('show', 'create', 'edit');
});

/* FRONTEND ROUTES */

/* Tweet */
Route::get('/', [FrontendTweetsController::class, 'index'])->name('frontend.tweets.index');
Route::get('/tweets/create', [FrontendTweetsController::class, 'create'])->name('frontend.tweets.create');
Route::get('/tweets/{tweet}', [FrontendTweetsController::class, 'show'])->name('frontend.tweets.show');
Route::get('/tweets/{tweet}/edit', [FrontendTweetsController::class, 'edit'])->name('frontend.tweets.edit');
Route::post('/tweets/{tweet}/votes/{vote}', [VotesController::class, 'voteTweet'])->name('tweets.vote');

/* Tag */
Route::get('/tags', [FrontendTagsController::class, 'index'])->name('frontend.tags.index');
Route::get('/tags/create', [FrontendTagsController::class, 'create'])->name('frontend.tags.create');
Route::get('/tags/{tag}', [FrontendTagsController::class, 'show'])->name('frontend.tags.show');
Route::get('/tags/{tag}/edit', [FrontendTagsController::class, 'edit'])->name('frontend.tags.edit');

/* User */
Route::get('/users', [FrontendUsersController::class, 'index'])->name('frontend.users.index');
Route::get('/users/notifications', [FrontendUsersController::class, 'notifications'])->name('frontend.users.notifications'); // internally the auth()->id() will be taken by me
Route::get('/users/{user}', [FrontendUsersController::class, 'show'])->name('frontend.users.show');
Route::get('/users/{user}/edit', [FrontendUsersController::class, 'edit'])->name('frontend.users.edit');

/* Replies */
Route::get('/tweets/{tweet}/replies/{answer}', [FrontendRepliesController::class, 'edit'])->name('frontend.tweets.replies.edit');
Route::post('/tweets/{tweet}/replies/{answer}/votes/{vote}', [VotesController::class, 'voteReplies'])->name('tweets.replies.vote');
