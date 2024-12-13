<?php

use App\Enums\NotificationType;
use App\Enums\UserOverview;
use App\Http\Controllers\RegisteredUserController;
use App\Http\Controllers\SessionController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;

Route::get('/', function () {
    return view('home');
});

Route::get('/settings', function () {
    $user = Auth::user();

    return view('settings', compact('user'));
})->middleware('auth');

Route::post('/settings', function (Request $request) {
    if ($request->type == "password") {
        $rule =  ['required', 'confirmed', Password::min(6)];
    } else if ($request->type == "email") {
        $rule =  ['required', 'email', 'unique:users,email'];
    } else if ($request->type == "username") {
        $rule =  ['required', 'unique:users,username'];
    } else {
        $rule =  ['required'];
    }

    $validation = Validator::make($request->all(), [
        'value' => $rule,
    ]);

    if (!$validation->fails()) {
        $user = User::where("id", $request->id)->first();
        if ($request->type == "password") {
            $user->password = bcrypt($request->value);
        } else if ($request->type == "email") {
            $user->email = $request->value;
        } else if ($request->type == "username") {
            $user->username = $request->value;
        } else if ($request->type == "name") {
            $user->name = $request->value;
        } else {
            return response()->json([
                "type" => $request->type,
                "error" => "Unknown request type: {$request['value']}",
            ], 422);
        }
        $user->save();

        return response()->json([
            "type" => $request->type,
        ], 200);
    } else {
        return response()->json([
            "type" => $request->type,
        ], 422);
    }

})->middleware('auth');

Route::get('/notifications', function () {
    $notifications = [
        [
            "type" => NotificationType::LIKE,
            "users" => [
                [
                    "username" => "person1",
                    "imageUrl" => "rust.png",
                ],
                [
                    "username" => "person2",
                    "imageUrl" => "python.png",
                ],
                [
                    "username" => "person3",
                    "imageUrl" => "kotlin.png",
                ],
            ],
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
            "type" => NotificationType::COMMENT,
            "users" => [
                [
                    "username" => "person3",
                    "imageUrl" => "kotlin.png",
                ],
            ],
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
            "type" => NotificationType::LIKE,
            "users" => [
                [
                    "username" => "person1",
                    "imageUrl" => "rust.png",
                ],
                [
                    "username" => "person3",
                    "imageUrl" => "kotlin.png",
                ],
            ],
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

    return view('notifications', compact('notifications'));
})->middleware('auth');

Route::prefix('users')->group(function () {
    Route::get('/{username}', function (string $username) {
        $user = User::where('username', $username)->first();
        
        $posts = [
            [
                "status" => UserOverview::POST,
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
                "status" => UserOverview::COMMENT,
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
                "status" => UserOverview::POST,
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
    
        return view('users.index', compact('user', 'posts'));
    })->name('user.index');

    Route::get('/{username}/posts', function (string $username) {
        $user = User::where('username', $username)->first();
        
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
    
        return view('users.posts', compact('user', 'posts'));
    })->name('user.posts');

    Route::get('/{username}/comments', function (string $username) {
        $user = User::where('username', $username)->first();
        
        $posts = [
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
        ];
    
        return view('users.comments', compact('user', 'posts'));
    })->name('user.comments');
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
