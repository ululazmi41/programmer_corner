<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Corner;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use function App\Helpers\getTrendingPosts;

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

        $trendingPosts = getTrendingPosts(3);

        foreach ($trendingPosts as $trendingPost) {
            $trendingPost->likesCount = count($trendingPost->likes);
            $trendingPost->commentsCount = count($trendingPost->comments);
        }

        return view('posts.create', compact('corner', 'trendingPosts'));
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
            'comments.likes',
            'comments.replies',
        ])->firstOrFail();

        $post->liked = $post->likes->contains('user_id', Auth::id());
        $post->likesCount = count($post->likes);

        foreach ($post->comments as $comment) {
            $comment->likesCount = count($comment->likes);
            $comment->liked = $comment->likes->contains('user_id', Auth::id());
            $comment->lastActivity = $comment->updated_at;

            foreach ($comment->replies as $reply) {
                $reply->likesCount = count($reply->likes);
                $reply->liked = $reply->likes->contains('user_id', Auth::id());

                if ($reply->updated_at->timestamp > $comment->lastActivity->timestamp) {
                    $comment->lastActivity = $reply->updated_at;
                }
            }
        }

        $post->comments = $post->comments->sortBy(function ($comment) {
            return -$comment->lastActivity->timestamp;
        });

        $trendingPosts = getTrendingPosts(3);

        foreach ($trendingPosts as $trendingPost) {
            $trendingPost->likesCount = count($trendingPost->likes);
            $trendingPost->commentsCount = count($trendingPost->comments);
        }

        return view('posts.show', compact('post', 'trendingPosts'));
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
