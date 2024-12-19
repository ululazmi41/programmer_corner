<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use App\Models\Corner;
use App\Models\Comment;
use App\Models\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
        if (Post::find($id) == null) {
            return redirect()->back();
        }

        if (Post::find($id)->views == null) {
            Post::find($id)->views()->create();
        }
        
        Post::find($id)->views->increment('count');

        $post = Post::where('id', $id)->with([
            'user',
            'views',
            'corner',
            'comments' => function ($query) {
                $query->whereNull('parent_id');
            },
            'comments.views',
            'comments.likes',
            'comments.replies',
            'comments.replies.views',
        ])->firstOrFail();

        $post->liked = $post->likes->contains('user_id', Auth::id());
        $post->likesCount = count($post->likes);

        foreach ($post->comments as $comment) {
            $comment->likesCount = count($comment->likes);
            $comment->liked = $comment->likes->contains('user_id', Auth::id());
            $comment->lastActivity = $comment->updated_at;

            if (Comment::find($comment->id)->views == null) {
                Comment::find($comment->id)->views()->create();
            }
            
            Comment::find($comment->id)->views->increment('count');
            $comment->viewsCount = Comment::find($comment->id)->views->count;

            foreach ($comment->replies as $reply) {
                $reply->likesCount = count($reply->likes);
                $reply->liked = $reply->likes->contains('user_id', Auth::id());

                if ($reply->updated_at->timestamp > $comment->lastActivity->timestamp) {
                    $comment->lastActivity = $reply->updated_at;
                }

                if (Comment::find($reply->id)->views == null) {
                    Comment::find($reply->id)->views()->create();
                }

                Comment::find($reply->id)->views->increment('count');
                $reply->viewsCount = Comment::find($reply->id)->views->count;
            }
        }

        $post->comments = $post->comments->sortBy(function ($comment) {
            return -$comment->lastActivity->timestamp;
        });

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
    public function destroy(String $id)
    {
        $post = Post::where('id', $id)->first();
        $post->delete();

        return redirect()->back();
    }
}
