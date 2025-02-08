<?php

namespace App\Http\Controllers;

use App\Enums\ContentType;
use App\Models\Post;
use App\Models\User;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;

use function App\Helpers\addBookmarks;
use function App\Helpers\addCountsPosts;
use function App\Helpers\addCountsComments;
use function App\Helpers\getNotifiableData;
use function App\Helpers\getNotificationEnumFromString;

class UserController extends Controller
{
    public function show(String $username)
    {
        $user = User::where('username', $username)->firstOrFail();

        $Postsquery = Post::query();
        $Postsquery->where('user_id', $user->id);
        $Postsquery->with([
            'user',
            'likes',
            'corner',
            'comments',
            'bookmarks',
        ]);
        $initialPosts = $Postsquery->get();

        foreach ($initialPosts as $post) {
            $post->type = ContentType::POST;
        }

        $countedPosts = addCountsPosts($initialPosts, $withReply=false);
        $bookmarkedPosts = addBookmarks($countedPosts);

        $commentsQuery = Comment::query();
        $commentsQuery->where('user_id', $user->id);
        $commentsQuery->with([
            'likes',
            'replies',
            'bookmarks',
            'post.corner',
        ]);
        $commentsQuery->withCount('replies');
        $initialComments = $commentsQuery->get();

        foreach ($initialComments as $comment) {
            $comment->type = ContentType::COMMENT;
            $comment->corner = $comment->post->corner;
        }

        $countedComents = addCountsComments($initialComments, $withReply=false);
        $bookmarkedComments = addBookmarks($countedComents);

        $sorted = $bookmarkedPosts->merge($bookmarkedComments)->sortByDesc(function ($query) {
            return $query->updated_at->timestamp;
        });

        $contents = $sorted;

        return view('users.index', compact('user', 'contents'));
    }

    public function posts(String $username)
    {
        $user = User::where('username', $username)->firstOrFail();

        $query = Post::query();
        $query->where('user_id', $user->id);
        $query->with([
            'user',
            'likes',
            'corner',
            'comments',
            'bookmarks',
        ]);
        $initial = $query->get();
        $counted = addCountsPosts($initial, $withReply=false);
        $bookmarked = addBookmarks($counted);
        $sorted = $bookmarked->sortByDesc(function ($query) {
            return $query->updated_at->timestamp;
        });
        $posts = $sorted;

        return view('users.posts', compact('user', 'posts'));
    }

    public function comments(String $username)
    {
        $user = User::where('username', $username)->firstOrFail();

        $query = Comment::query();
        $query->where('user_id', $user->id);
        $query->with([
            'likes',
            'replies',
            'bookmarks',
            'post.corner',
        ]);
        $query->withCount('replies');
        $initial = $query->get();

        foreach ($initial as $comment) {
            $comment->type = ContentType::COMMENT;
            $comment->corner = $comment->post->corner;
        }

        $counted = addCountsComments($initial, $withReply=false);
        $bookmarked = addBookmarks($counted);
        $sorted = $bookmarked->sortByDesc(function ($query) {
            return $query->updated_at->timestamp;
        });
        $comments = $sorted;

        return view('users.comments', compact('user', 'comments'));
    }

    public function likes(String $username)
    {
        $user = User::where('username', $username)->first();

        $postsQuery = Post::query();
        $postsQuery->with([
            'user',
            'corner',
            'bookmarks',
            'likes' => function ($query) use($user) {
                return $query->where('user_id', $user->id);
            },
        ]);
        $postsQuery->withCount('likes', 'comments');
        $postsQuery->whereHas('likes', function ($query) use($user) {
            return $query->where('user_id', $user->id);
        })->get();
        $unprocessedPost = $postsQuery->get();

        foreach ($unprocessedPost as $post) {
            $post->type = ContentType::POST;
        }

        $addedCountsPosts = addCountsPosts($unprocessedPost);
        $addedBookmarksPosts = addBookmarks($addedCountsPosts);
        $posts = $addedBookmarksPosts;

        $commentsQuery = Comment::query();
        
        $commentsQuery->with([
            'bookmarks',
            'post.corner',
            'replies',
            'likes' => function ($query) use($user) {
                return $query->where('user_id', $user->id);
            },
        ]);
        $commentsQuery->withCount('replies');
        $commentsQuery->whereHas('likes', function ($query) use($user) {
            return $query->where('user_id', $user->id);
        });

        $unprocessedComments = $commentsQuery->get();

        foreach ($unprocessedComments as $comment) {
            $comment->type = ContentType::COMMENT;
            $comment->corner = $comment->post->corner;
        }

        $addedCountsComments = addCountsComments($unprocessedComments);
        $addedBookmarksComments = addBookmarks($addedCountsComments);
        $comments = $addedBookmarksComments;

        $combined = $posts->concat($comments)->sortByDesc(function ($query) {
            return $query->likes->first()->created_at->timestamp;
        });

        $contents = $combined;

        return view('users.likes', compact('user', 'contents'));
    }

    public function bookmarks(String $username)
    {
        $user = User::where('username', $username)->first();

        $unprocessedPost = Post::with([
                'user',
                'corner',
                'bookmarks' => function ($query) use ($user) {
                    return $query->where('user_id', $user->id)->limit(1);
                },
            ])
            ->withCount('likes', 'comments')
            ->whereHas('bookmarks', function ($query) use ($user) {
                return $query->where('user_id', $user->id);
            })
            ->get();

        foreach ($unprocessedPost as $post) {
            $post->type = ContentType::POST;
        }

        $addedCountsPosts = addCountsPosts($unprocessedPost);
        $addedBookmarksPosts = addBookmarks($addedCountsPosts);
        $posts = $addedBookmarksPosts;

        $unprocessedComments = Comment::with([
            'replies',
            'post.corner',
            'bookmarks' => function ($query) use ($user) {
                    return $query->where('user_id', $user->id);
                },
            ])
            ->withCount('replies', 'bookmarks')
            ->whereHas('bookmarks', function ($query) use ($user) {
                return $query->where('user_id', $user->id);
            })->get();

        foreach ($unprocessedComments as $comment) {
            $comment->type = ContentType::COMMENT;
            $comment->corner = $comment->post->corner;
        }

        $addedCountsComments = addCountsComments($unprocessedComments);
        $addedBookmarksComments = addBookmarks($addedCountsComments);
        $comments = $addedBookmarksComments;
        
        $combined = $posts->merge($comments)->sortByDesc(function ($query) {
            return $query->bookmarks()->first()->created_at;
        });

        $bookmarks = $combined;

        return view('users.bookmarks', compact('user', 'bookmarks'));
    }

    public function notifications() {
        $raw = User::find(Auth::id())->notifications;
        $notifications = [];
        $notifications_indices = [];

        foreach ($raw as $notification) {
            $model = getNotifiableData([
                'notifiable_id' => $notification->notifiable_id,
                'notifiable_type' => $notification->notifiable_type,
            ]);
            if ($model === null) {
                continue;
            }

            $key = $notification->type . '.' .  $notification->notifiable_type . $notification->notifiable_id;
            if (array_key_exists($key, $notifications_indices)) {
                $index = $notifications_indices[$key];
                array_push($notifications[$index]['users'], $notification->notifier);
                continue;
            }

            $data = [
                'type' => getNotificationEnumFromString($notification->type),
                'users' => [
                    $notification->notifier,
                ],
                'notifiable_type' => $notification->notifiable_type,
                'notifiable_data' => $model,
            ];

            $notifications_indices[$key] = count($notifications);
            array_push($notifications, $data);
        }

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

    public function put(Request $request)
    {
        if ($request->type == "password") {
            $rule = ['required', 'confirmed', Password::min(6)];
        } else if ($request->type == "email") {
            $rule = ['required', 'email', 'unique:users,email'];
        } else if ($request->type == "username") {
            $rule = ['required', 'unique:users,username'];
        } else {
            $rule = ['required'];
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
            } else if ($request->type == "description") {
                $user->description = $request->value;
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

    public function follow(String $username)
    {
        $user = User::find(Auth::id());
        $following = User::where('username', $username)->firstOrFail();

        $user->follow($following);

        return response()->json([
            "status" => "ok",
        ], 200);
    }

    public function unfollow(String $username)
    {
        $user = User::find(Auth::id());
        $following = User::where('username', $username)->firstOrFail();

        $user->unfollow($following);

        return response()->json([
            "status" => "ok",
        ], 200);
    }

    public function following(String $username)
    {
        $user = User::where('username', $username)->firstOrFail();
        return view('users.following', compact('user'));
    }

    public function followers(String $username)
    {
        $user = User::where('username', $username)->firstOrFail();
        return view('users.followers', compact('user'));
    }

    public function destroy(User $user) {
        $user->delete();

        Auth::logout();

        return redirect('/');
    }
}
