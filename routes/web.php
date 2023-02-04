<?php

use App\Http\Controllers\AnswersController;
use App\Http\Controllers\Frontend\FrontendAnswersController;
use App\Http\Controllers\Frontend\FrontendQuestionsController;
use App\Http\Controllers\Frontend\FrontendTagsController;
use App\Http\Controllers\Frontend\FrontendUsersController;
use App\Http\Controllers\QuestionsController;
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
    Route::resource('questions', QuestionsController::class)->except('show', 'create', 'edit');

    /* TAGS */
    Route::resource('tags', TagsController::class)->except('show', 'create', 'edit');

    /* ANSWER */
    Route::resource('questions.answers', AnswersController::class)->except('show', 'create', 'edit');
    Route::put('questions/{question}/answers/{answer}/mark-as-best', [QuestionsController::class, 'markAsBest'])->name('questions.answers.markAsBest');

    /* USER */
    Route::resource('users', UsersController::class)->except('show', 'create', 'edit');
});

/* FRONTEND ROUTES */

/* Question */
Route::get('/', [FrontendQuestionsController::class, 'index'])->name('frontend.questions.index');
Route::get('/questions/create', [FrontendQuestionsController::class, 'create'])->name('frontend.questions.create');
Route::get('/questions/{question}', [FrontendQuestionsController::class, 'show'])->name('frontend.questions.show');
Route::get('/questions/{question}/edit', [FrontendQuestionsController::class, 'edit'])->name('frontend.questions.edit');
Route::post('/questions/{question}/votes/{vote}', [VotesController::class, 'voteQuestion'])->name('questions.vote');

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

/* Answer */
Route::get('/questions/{question}/answers/{answer}', [FrontendAnswersController::class, 'edit'])->name('frontend.questions.answers.edit');
Route::post('/questions/{question}/answers/{answer}/votes/{vote}', [VotesController::class, 'voteAnswer'])->name('questions.answers.vote');
