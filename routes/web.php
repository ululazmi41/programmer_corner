<?php

use App\Http\Controllers\BookmarkController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\CornerController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\RegisteredUserController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\UserController;
use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use function App\Helpers\addBookmarks;
use function App\Helpers\addCountsPosts;
use function App\Helpers\sortPostsByPopularity;

Route::get('test', function() {
    dd('test');
});

Route::controller(ChatController::class)->prefix('chat')->group(function () {
    Route::get('/', 'index')->middleware('auth')->name('chat');
    Route::post('/join', 'join');
    Route::get('/{id}', 'fetch');
    Route::post('/send-message', 'sendMessage');
    Route::post('/leave', 'leave');
    Route::post('/remove', 'remove');
});

Route::get('/', function () {
    $rawPosts = Post::whereHas('corner', function ($query) {
        $query->where('private', false);
    })->get();
    $addedCounts = addCountsPosts($rawPosts);
    $addedBookmarks = addBookmarks($addedCounts);
    $sorted = sortPostsByPopularity($addedBookmarks);
    $posts = $sorted;

    return view('home', compact('posts'));
});

Route::controller(BookmarkController::class)->group(function () {
    Route::post('/bookmarks', 'store')->middleware('auth')->name('bookmarks.post');
    Route::delete('/bookmarks/{id}', 'destroy')->middleware('auth')->name('bookmarks.destroy');
});

Route::get('/search', function (Request $request) {
    $query = $request->input('query');
    $initial = Post::where('title', 'like', '%' . $query . '%')
    ->orWhere('content', 'like', '%' . $query . '%')
    ->with(['likes', 'comments'])
    ->get();
    $counted = addCountsPosts($initial);
    $bookmarked = addBookmarks($counted);
    $posts = $bookmarked;

    return view('search', compact('posts'));
})->name('search');

Route::controller(LikeController::class)->group(function () {
    Route::post('/likes', 'store');
    Route::delete('/likes', 'destroy');
})->middleware('auth');

Route::controller(CommentController::class)->group(function () {
    Route::get('/comments', function () {
        return Comment::all();
    });
    Route::post('/comments', 'store')->middleware('auth');
    Route::delete('/comments/{id}', 'destroy')->middleware('auth')->name('comments.destroy');
    Route::put('/comments/{comment}', 'update')->middleware('auth');
});

Route::controller(PostController::class)->group(function () {
    Route::get('/corners/{id}/create-post', 'create')->middleware('auth');
    Route::get('/posts/{id}', 'show')->name('posts.show');
    Route::get('/posts/{post}/edit', 'edit')->name('posts.edit');
    Route::put('/posts/{post}', 'update')->middleware('auth')->name('posts.update');
    Route::post('/posts', 'store')->middleware('auth')->name('post.post');
    Route::delete('/posts/{id}', 'destroy')->middleware('auth')->name('posts.destroy');
});

Route::controller(CornerController::class)->group(function () {
    Route::get('/corners', 'index')->name('corners.index');
    Route::get('/corners/{handle}', 'show')->name('corners.show');
    Route::get('/corners/{id}/join', 'join')->middleware('auth');
    Route::get('/corners/{id}/leave', 'leave')->middleware('auth');
    Route::put('/corners/{id}', 'update')->middleware('auth');

    Route::get('/corners/{handle}/settings', 'settings')->middleware('auth');

    Route::post('/corners/{id}/settings/icon', 'setIcon')->middleware('auth');
    Route::delete('/corners/{id}/settings/icon', 'deleteIcon')->middleware('auth');

    Route::post('/corners/{id}/settings/banner', 'setBanner')->middleware('auth');
    Route::delete('/corners/{id}/settings/banner', 'deleteBanner')->middleware('auth');

    Route::get('/create-corner', 'create')->middleware('auth');
    Route::post('/create-corner', 'store')->middleware('auth');

    Route::delete('/corners/{corner}', 'destroy')->middleware('auth')->name('corners.destroy');

    Route::get('/corners/toggle-visibility/{corner}', 'toggleVisibility')->middleware('auth')->name('corners.toggle-visibility');

    Route::get('/corners/{corner}/members', 'members')->name('corners.members');

    Route::post('/corners/{corner}/members/{member}/update-role', 'updateRole')->middleware('auth')->name('corners.members.updateRole');
});

Route::controller(UserController::class)->group(function () {
    Route::prefix('users/{username}')->group(function () {
        Route::get('/', 'show')->name('users.show');
        Route::get('posts', 'posts')->name('user.posts');
        Route::get('comments', 'comments')->name('user.comments');

        Route::get('likes', 'likes')->middleware('auth')->name('user.likes');
        Route::get('bookmarks', 'bookmarks')->middleware('auth')->name('user.bookmarks');

        Route::post('follow', 'follow')->middleware('auth')->name('user.follow');
        Route::delete('unfollow', 'unfollow')->middleware('auth')->name('user.unfollow');
        
        Route::get('following', 'following')->name('user.following');
        Route::get('followers', 'followers')->name('user.followers');
    });

    Route::prefix("settings")->group(function () {
        Route::get('/', 'settings')->middleware('auth');
        Route::post('/', 'put')->middleware('auth');
        Route::post("icon", 'setIcon');
        Route::delete('icon', 'deleteIcon');
    });

    Route::delete('/users/{user}', 'destroy')->middleware('auth')->name('users.destroy');
    Route::get('/notifications', 'notifications')->middleware('auth');
});

Route::controller(RegisteredUserController::class)->group(function () {
    Route::get('/register', 'create')->middleware('guest');
    Route::post('/register', 'store')->middleware('guest');
});

Route::controller(SessionController::class)->group(function () {
    Route::get('/login', 'create')->middleware('guest')->name('login');
    Route::post('/login', 'store')->middleware('guest');
    Route::GET('/logout', 'destroy')->middleware('auth');
});
