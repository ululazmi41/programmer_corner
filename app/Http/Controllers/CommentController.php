<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
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
        $request->validate([
            'body' => ['required'],
        ]);

        if (!Auth::check()) {
            redirect()->route('login');
        }

        $user = User::where('id', Auth::user()->id)->first();
        $post = Post::where('id', $request->post_id)->first();

        $post->comments()->create([
            'user_id' => $user->id,
            'body' => $request->body,
            'parent_id' => $request->parent_id,
        ]);

        return redirect()->route('posts.show', ['id' => $request->post_id]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Comment $comment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Comment $comment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Comment $comment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(String $id)
    {
        $comment = Comment::find($id);
        $comment->delete();

        return redirect()->back();
    }
}
