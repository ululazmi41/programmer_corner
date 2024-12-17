<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Corner;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
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
    public function create(String $handle)
    {
        $corner = Corner::where('handle', $handle)->firstOrFail();

        $user = User::where('id', Auth::user()->id)->first();
        $joined = $user->corners->contains($corner->id);
        $owner = $user->createdCorners->contains($corner);
        if (!$joined && !$owner) {
            return redirect('/');
        }

        return view('posts.create', compact('corner'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => ['required'],
            'content' => ['nullable'],
        ]);

        $user = User::where('id', Auth::user()->id)->first();
        $corner = Corner::where('id', $request->corner_id)->first();

        $joined = $user->corners->contains($corner->id);
        $owner = $user->createdCorners->contains($corner);
        if (!$joined && !$owner) {
            return redirect('/');
        }

        $corner->posts()->create([
            'user_id' => $user->id,
            'title' => $request->title,
            'content' => $request->content,
            'likes' => 0,
        ]);

        return redirect()->route('corners.show', ['id' => $corner->handle]);
    }

    /**
     * Display the specified resource.
     */
    public function show(String $id)
    {
        $post = Post::where('id', $id)->with([
            'user',
            'corner',
            'comments' => function ($query) {
                $query->whereNull('parent_id');
            },
            'comments.replies',
        ])->firstOrFail();

        $post->likes = rand(1, 900);

        foreach ($post->comments as $comment) {
            $comment->likes = rand(1, 900);

            foreach ($comment->replies as $reply) {
                $reply->likes = rand(1, 900);
            }
        }

        return view('posts.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        //
    }
}
