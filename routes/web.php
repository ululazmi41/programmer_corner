<?php

use App\Http\Controllers\BookmarkController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\CornerController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\RegisteredUserController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\UserController;
use App\Models\Bookmark;
use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

use function App\Helpers\addCountsPosts;
use function App\Helpers\addPostsBookmarks;
use function App\Helpers\sortPostsByPopularity;

Route::get('/', function () {
    $rawPosts = Post::all();
    $addedCounts = addCountsPosts($rawPosts);
    $addedBookmarks = addPostsBookmarks($addedCounts);
    $sorted = sortPostsByPopularity($addedBookmarks);
    $posts = $sorted;

    return view('home', compact('posts'));
});

Route::get('/test', function () {
    dd(Bookmark::all());
    dd(User::where('id', Auth::id())->with('bookmarks')->first()->bookmarks);
});

Route::controller(BookmarkController::class)->group(function () {
    Route::post('/bookmarks', 'store')->middleware('auth')->name('bookmarks.post');
    Route::delete('/bookmarks/{id}', 'destroy')->middleware('auth')->name('bookmarks.destroy');
});

Route::get('/search', function (Request $request) {
    $query = $request->input('query');
    $posts = Post::where('title', 'like', '%' . $query . '%')
    ->orWhere('content', 'like', '%' . $query . '%')
    ->with(['likes', 'comments'])
    ->get();
    $posts = addCountsPosts($posts);

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
});

Route::controller(PostController::class)->group(function () {
    Route::get('/corners/{id}/create-post', 'create')->middleware('auth');
    Route::get('/posts/{id}', 'show')->name('posts.show');
    Route::post('/posts', 'store')->name('post.post')->middleware('auth');
    Route::delete('/posts/{id}', 'destroy')->middleware('auth')->name('posts.destroy');
});

Route::controller(CornerController::class)->group(function () {
    Route::get('/corners', 'index');
    Route::get('/corners/{id}', 'show')->name('corners.show');
    Route::get('/corners/{id}/join', 'join')->middleware('auth');
    Route::get('/corners/{id}/leave', 'leave')->middleware('auth');

    Route::get('/create-corner', 'create')->middleware('auth');
    Route::post('/create-corner', 'store')->middleware('auth');
});

Route::controller(UserController::class)->group(function () {
    Route::prefix('users')->group(function () {
        Route::get('{username}', 'show')->name('users.show');
        Route::get('{username}/posts', 'posts')->name('user.posts');
        Route::get('{username}/comments', 'comments')->name('user.comments');
        Route::get('{username}/bookmarks', 'bookmarks')->middleware('auth')->name('user.bookmarks');
    });

    Route::prefix("settings")->group(function () {
        Route::get('/', 'settings')->middleware('auth');
        Route::post('/', 'put')->middleware('auth');
        Route::post("icon", 'setIcon');
        Route::delete('icon', 'deleteIcon');
    });

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
