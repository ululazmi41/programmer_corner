<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Like;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
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
            $alreadyLiked = $post->likes->contains('user_id', Auth::id());
            if ($alreadyLiked == false) {
                Like::create([
                    'user_id' => Auth::id(),
                    'likeable_id' => intval($request->id),
                    'likeable_type' => Post::class,
                ]);
            } else {
                $like = $post->likes()->where('user_id', Auth::id());
                $like->delete();
            }
        } else if ($request->type == 'comment') {
            $comment = Comment::where('id', intval($request->id))->first();
            $alreadyLiked = $comment->likes->contains('user_id', Auth::id());
            if ($alreadyLiked == false) {
                Like::create([
                    'user_id' => Auth::id(),
                    'likeable_id' => intval($request->id),
                    'likeable_type' => Comment::class,
                ]);
            } else {
                $like = $comment->likes()->where('user_id', Auth::id());
                $like->delete();
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
    public function show(Like $like)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Like $like)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Like $like)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Like $like)
    {
        //
    }
}
