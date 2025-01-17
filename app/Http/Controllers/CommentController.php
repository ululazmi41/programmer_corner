<?php

namespace App\Http\Controllers;

use App\Enums\NotificationType;
use App\Models\Post;
use App\Models\User;
use App\Models\Comment;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use function App\Helpers\addCountsComment;

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

        $user = User::where('id', Auth::user()->id)->first();
        $post = Post::where('id', $request->post_id)->first();

        $comment = $post->comments()->create([
            'user_id' => $user->id,
            'body' => $request->body,
            'parent_id' => $request->parent_id,
        ]);

        if ($request->parent_id) {
            $parent = Comment::find($request->parent_id);
            Notification::sendNotification($parent->user->id, Auth::id(), NotificationType::REPLY, Comment::class, $comment->id);
        } else {
            Notification::sendNotification($post->user->id, Auth::id(), NotificationType::COMMENT, Comment::class, $comment->id);
        }

        $unprocessed = Comment::where('id', $comment->id)->with(
                'views',
                'likes',
                'replies',
                'replies.views',
            )->first();

        $counted = addCountsComment($unprocessed);
        $comment = $counted;

        $commentHtml = "";
        if ($request->parent_id) {
            $commentHtml = view('components.comment', [
                'comment' => $comment,
                'post' => $post,
                'hideReply' => true,
            ])->render();
        } else {
            $commentHtml = view('components.comment', [
                'comment' => $comment,
                'post' => $post,
                'replyId' => "comment#{$comment->id}",
            ])->render();
        }

        return response()->json([
            'commentHtml' => $commentHtml,
            'comment' => $comment,
        ], 200);
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

        if ($comment->parent_id) {
            Notification::removeNotification($comment->parent->user->id, Auth::id(), NotificationType::REPLY, Comment::class, $comment->id);
        } else {
            Notification::removeNotification($comment->post->user->id, Auth::id(), NotificationType::COMMENT, Comment::class, $comment->id);
        }

        return redirect()->back();
    }
}
