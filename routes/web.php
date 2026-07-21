<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TweetController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\RetweetController;
use App\Http\Controllers\FollowController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\SearchController;




Route::middleware('auth')->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');

    Route::get('/profile/{user}', [ProfileController::class, 'show'])->name('profile.show');

    Route::post('/tweets', [TweetController::class, 'store'])->name('tweets.store');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::post('/tweets/{tweet}/like', [TweetController::class, 'like'])->name('tweets.like');

    Route::post('/tweets/{tweet}/retweet', [RetweetController::class, 'toggle'])->name('tweets.retweet');

    Route::post('/tweets/{tweet}/comments', [CommentController::class, 'store'])->name('comments.store');

    Route::get('/tweets/{tweet}/edit', [TweetController::class, 'edit'])->name('tweets.edit');

    Route::put('/tweets/{tweet}', [TweetController::class, 'update'])->name('tweets.update');

    Route::delete('/tweets/{tweet}', [TweetController::class, 'destroy'])->name('tweets.destroy');

    Route::post('/users/{user}/follow', [FollowController::class, 'store'])->name('users.follow');

    Route::delete('/users/{user}/follow', [FollowController::class, 'destroy'])->name('users.unfollow');

    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');

    Route::get('/search', [SearchController::class, 'index'])->name('search.index');
});

require __DIR__.'/auth.php';
