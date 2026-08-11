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
use App\Http\Controllers\BookmarkController;
use App\Http\Controllers\ConversationController;
use App\Http\Controllers\MessageController;
use Kreait\Firebase\Contract\Database;

Route::middleware('auth')->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');

    Route::get('/profile/{user}', [ProfileController::class, 'show'])->name('profile.show');

    Route::post('/tweets', [TweetController::class, 'store'])->name('tweets.store');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/users/{user}/followers', [ProfileController::class, 'followers'])->name('profile.followers');

    Route::get('/users/{user}/following', [ProfileController::class, 'following'])->name('profile.following');

    Route::post('/tweets/{tweet}/like', [TweetController::class, 'like'])->name('tweets.like');

    Route::post('/tweets/{tweet}/retweet', [RetweetController::class, 'toggle'])->name('tweets.retweet');

    Route::post('/tweets/{tweet}/quote', [RetweetController::class, 'store'])->name('tweets.quote');

    Route::post('/tweets/{tweet}/comments', [CommentController::class, 'store'])->name('comments.store');

    Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');

    Route::get('/tweets/{tweet}', [TweetController::class, 'show'])->name('tweets.show');

    Route::get('/tweets/{tweet}/edit', [TweetController::class, 'edit'])->name('tweets.edit');

    Route::put('/tweets/{tweet}', [TweetController::class, 'update'])->name('tweets.update');

    Route::delete('/tweets/{tweet}', [TweetController::class, 'destroy'])->name('tweets.destroy');

    Route::post('/users/{user}/follow', [FollowController::class, 'store'])->name('users.follow');

    Route::delete('/users/{user}/follow', [FollowController::class, 'destroy'])->name('users.unfollow');

    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');

    Route::get('/search', [SearchController::class, 'index'])->name('search.index');

    Route::post('/tweets/{tweet}/bookmark', [BookmarkController::class, 'toggle'])->name('tweets.bookmark');

    Route::get('/bookmarks', [BookmarkController::class, 'index'])->name('bookmarks.index');

    Route::get('/messages', [MessageController::class, 'index'])->name('messages.index');

    Route::post('/messages/{user}', [MessageController::class, 'store'])->name('messages.store');

    Route::get('/messages/{message}/html', [MessageController::class, 'html'])->name('messages.html');

    Route::get('/messages/{conversation}', [MessageController::class, 'show'])->name('messages.show');

    Route::post('/conversations/{conversation}/messages', [MessageController::class, 'send'])->name('messages.send');

    // Firebase Test Route (Temporary)
    Route::get('/test-firebase', function (Database $database) {
        $database->getReference('test')->set([
            'message' => 'Firebase Connected Successfully!',
            'time' => now()->toDateTimeString(),
        ]);

        return 'Firebase connection successful!';
    });
});

require __DIR__.'/auth.php';
