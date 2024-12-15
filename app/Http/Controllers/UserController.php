<?php

namespace App\Http\Controllers;

use App\Enums\NotificationType;
use App\Enums\UserOverview;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{
    public function show(String $username) {
        $user = User::where('username', $username)->first();
            
        $posts = [
            [
                "status" => UserOverview::POST,
                "author" => "Python",
                "date" => "1/12/2024",
                "image_url" => "python.png",
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
                "image_url" => "go.png",
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
                "image_url" => "rust.png",
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
    }

    public function posts(String $username) {
        $user = User::where('username', $username)->first();
        
        $posts = [
            [
                "author" => "Python",
                "date" => "1/12/2024",
                "image_url" => "python.png",
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
                "image_url" => "rust.png",
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
    }

    public function comments(String $username) {
        $user = User::where('username', $username)->first();
        
        $posts = [
            [
                "author" => "Golang",
                "date" => "3/12/2024",
                "image_url" => "go.png",
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
    }

    public function notifications() {
        $notifications = [
            [
                "type" => NotificationType::LIKE,
                "users" => [
                    [
                        "username" => "person1",
                        "image_url" => "rust.png",
                    ],
                    [
                        "username" => "person2",
                        "image_url" => "python.png",
                    ],
                    [
                        "username" => "person3",
                        "image_url" => "kotlin.png",
                    ],
                ],
                "author" => "Python",
                "date" => "1/12/2024",
                "image_url" => "python.png",
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
                        "image_url" => "kotlin.png",
                    ],
                ],
                "author" => "Golang",
                "date" => "3/12/2024",
                "image_url" => "go.png",
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
                        "image_url" => "rust.png",
                    ],
                    [
                        "username" => "person3",
                        "image_url" => "kotlin.png",
                    ],
                ],
                "author" => "Rust",
                "date" => "26/11/2024",
                "image_url" => "rust.png",
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
    }

    public function settings()
    {
        $user = Auth::user();

        return view('settings', compact('user'));
    }

    public function deleteIcon()
    {
        $filepath = 'icons/' . Auth::user()->image_url;

        if (Storage::disk('public')->exists($filepath)) {
            Storage::disk('public')->delete($filepath);

            $user = User::where('id', Auth::user()->id)->first();
            $user->image_url = null;
            $user->save();

            return response()->json([
                "status" => "ok",
            ], 200);
        } else {
            return response()->json([
                "status" => "error",
            ], 500);
        }
    }

    public function setIcon(Request $request)
    {
        $oldpath = 'icons/' . Auth::user()->image_url;

        if (Storage::disk('public')->exists($oldpath)) {
            Storage::disk('public')->delete($oldpath);

            $user = User::where('id', Auth::user()->id)->first();
            $user->image_url = null;
            $user->save();
        }

        $filename = Str::uuid() . '.' . $request->file('icon')->getClientOriginalExtension();
        $filepath = $request->file('icon')->storeAs('icons', $filename, 'public');

        $filepath = 'icons/' . Auth::user()->image_url;

        $user = User::where('id', Auth::user()->id)->first();
        $user->image_url = $filename;
        $user->save();

        return response()->json([
            "filename" => $filename,
            "filepath" => $filepath,
        ], 200);
    }

    public function modifySettings(Request $request)
    {
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
    }
}
