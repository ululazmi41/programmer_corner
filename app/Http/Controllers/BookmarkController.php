<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Comment;
use App\Models\Bookmark;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookmarkController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (!Auth::check()) {
            return response()->json([
                'message' => 'Unauthorized',
            ], 401);
        }

        if ($request->type == 'post') {
            $post = Post::where('id', intval($request->id))->first();
            $exist = $post->bookmarks->contains('user_id', Auth::id());
            
            if ($exist == false) {
                Bookmark::create([
                    'user_id' => Auth::id(),
                    'bookmarkable_id' => intval($request->id),
                    'bookmarkable_type' => Post::class,
                ]);
            } else {
                $bookmark = $post->bookmarks()->where('user_id', Auth::id());
                $bookmark->delete();
            }
        } else if ($request->type == 'comment') {
            $comment = Comment::where('id', intval($request->id))->first();
            $exist = $comment->bookmarks->contains('user_id', Auth::id());
            
            if ($exist == false) {
                Bookmark::create([
                    'user_id' => Auth::id(),
                    'bookmarkable_id' => intval($request->id),
                    'bookmarkable_type' => Comment::class,
                ]);
            } else {
                $bookmark = $comment->bookmarks()->where('user_id', Auth::id());
                $bookmark->delete();
            }
        } else {
            return response()->json([
                'message' => 'Internal server error',
            ], 500);
        }

        return response()->json([
            "status" => "ok",
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Bookmark $bookmark)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Bookmark $bookmark)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Bookmark $bookmark)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Bookmark $bookmark)
    {
        //
    }
}
