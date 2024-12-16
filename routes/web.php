<?php

use App\Http\Controllers\CornerController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\RegisteredUserController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});

Route::controller(PostController::class)->group(function () {
    Route::get('/corners/{id}/create-post', 'create')->middleware('auth');
    Route::post('/posts', 'store')->name('post.post')->middleware('auth');
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
        Route::get('{username}', 'show')->name('user.index');
        Route::get('{username}/posts', 'posts')->name('user.posts');
        Route::get('{username}/comments', 'comments')->name('user.comments');
    });

    Route::prefix("settings")->group(function () {
        Route::get('/', 'settings')->middleware('auth');
        Route::post('/', 'modifySettings')->middleware('auth');
        Route::post("icon", 'setIcon');
        Route::delete('icon', 'deleteIcon');
    });

    Route::get('/notifications', 'notifications')->middleware('auth');
});

Route::get('/search', function (Request $request) {
    $query = $request->input('query');
    $posts = [];
    if ($query == '') {
        //
    } else {
        $posts = [
            [
                "author" => "Python",
                "date" => "1/12/2024",
                "imageUrl" => "python.png",
                "title" => "What's the cheapest way to host a python script?",
                "description" => "Hello, I have a Python script that I need to run every minute. I came across PythonAnywhere, which costs about $5 per month for the first Tier Account. Are there any cheaper alternatives to keep my script running? Would it be more cost-effective to run the script continuously by leaving my computer on? I’m new to this, so any advice or suggestions would be greatly appreciated. Thank you! ",
                "likes" => "13",
                "comments" => "21",
                "views" => "1.2K",
                "liked" => "true",
                "featured" => "true",
                "bookmark" => "true",
            ],
            [
                "author" => "Golang",
                "date" => "3/12/2024",
                "imageUrl" => "go.png",
                "title" => "Advent of Code 2024 Day 1: Missing abs() for integers",
                "description" => "Wrote a blog about this year's advent of code day 1. While solving the problem I was once again struck with the missing function for calculating absolute value for integers and decided to dig a lil deeper. You'll also find a small recap of how the abs() function for floats evolved over time in the standard library. ",
                "likes" => "7",
                "comments" => "3",
                "views" => "419",
                "liked" => "false",
                "featured" => "false",
                "bookmark" => "false",
            ],
            [
                "author" => "Rust",
                "date" => "26/11/2024",
                "imageUrl" => "rust.png",
                "title" => "Anyone actually using io_uring with rust in production? What's the experience like?",
                "description" => "I have a long running program that ingests a lot of data and then pushes them to subscribed listeners. Recently the amount of data for ingesting has increased and I am facing a bottleneck while parsing the data. I am rethinking the architecture and want to try io_uring. So what has been your experience with it in rust? Has there been any downside to using runtimes like glommio or tokio_uring?",
                "likes" => "31",
                "comments" => "7",
                "views" => "122",
                "liked" => "false",
                "featured" => "false",
                "bookmark" => "true",
            ],
        ];
    }

    $posts = [];

    return view('search', compact('posts'));
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
