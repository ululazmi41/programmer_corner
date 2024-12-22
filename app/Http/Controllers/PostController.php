<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use App\Models\Corner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use function App\Helpers\addCountsPost;
use function App\Helpers\sortCommentsByLastActivity;

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

        return redirect()->route('corners.show', ['handle' => $corner->handle]);
    }

    /**
     * Display the specified resource.
     */
    public function show(String $id)
    {
        if (Post::find($id) == null) {
            return redirect()->back();
        }

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

        $postWithCount = addCountsPost($post, $withComments = true);
        $sortedPost = sortCommentsByLastActivity($post);

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
        $corner = $post->corner;
        $user = User::where('id', Auth::user()->id)->first();

        $joined = $user->corners->contains($corner->id);
        $owner = $user->createdCorners->contains($corner);
        if (!$joined && !$owner) {
            return redirect('/');
        }

        return view('posts.edit', compact('post', 'corner'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        $validate = $request->validate([
            'title' => ['required'],
            'content' => ['nullable'],
        ]);

        $post->update($validate);
        return redirect()->route('posts.show', ['id' => $post->id]);
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
