<?php

namespace App\Helpers;

use App\Models\Post;
use App\Models\User;
use App\Models\Comment;
use App\Models\Corner;
use App\Enums\NotificationType;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Collection;

function getNotificationEnumFromString(String $enum): NotificationType
{
    foreach (NotificationType::cases() as $case) {
        if ($case->value === $enum) {
            return $case;
        }
    }

    return null;
}

function getNotifiableData($notification): Post | Comment | User | Corner | null
{
    if ($notification['notifiable_type'] === Post::class) {
        return Post::find($notification['notifiable_id']);
    }

    if ($notification['notifiable_type'] === Comment::class) {
        return Comment::find($notification['notifiable_id']);
    }

    if ($notification['notifiable_type'] === User::class) {
        return User::find($notification['notifiable_id']);
    }

    if ($notification['notifiable_type'] === Corner::class) {
        return Corner::find($notification['notifiable_id']);
    }

    return null;
}

function addBookmarks(Collection $collections): Collection {
    foreach ($collections as $collection) {
        $collection->bookmarked = $collection->bookmarks->contains('user_id', Auth::id());
    }
    return $collections;
}

function sortPostsByPopularity(Collection $posts): Collection {
    return $posts->sortByDesc(function ($post) {
        return $post->likesCount + $post->commentsCount + $post->viewsCount;
    });
}

function sortCommentsByLastActivity(Post &$post): Post {
    foreach ($post->comments as $comment) {
        $comment->lastActivity = $comment->updated_at;
        
        foreach ($comment->replies as $reply) {
            if ($reply->updated_at->timestamp > $comment->lastActivity->timestamp) {
                $comment->lastActivity = $reply->updated_at;
            }
        }
    }

    return $post;
}

function addCountsComment(Comment $comment, bool $withReply = true): Comment {
    $comment->likesCount = count($comment->likes);
    $comment->liked = $comment->likes->contains('user_id', Auth::id());

    if (Comment::find($comment->id)->views == null) {
        Comment::find($comment->id)->views()->create();
    }
    
    Comment::find($comment->id)->views->increment('count');
    $comment->viewsCount = Comment::find($comment->id)->views->count;

    if ($withReply) {
        foreach ($comment->replies as $reply) {
            $reply->likesCount = count($reply->likes);
            $reply->liked = $reply->likes->contains('user_id', Auth::id());
    
            if (Comment::find($reply->id)->views == null) {
                Comment::find($reply->id)->views()->create();
            }
    
            Comment::find($reply->id)->views->increment('count');
            $reply->viewsCount = Comment::find($reply->id)->views->count;
        }
    }

    return $comment;
}

function addCountsComments(Collection $comments, bool $withReply = true): Collection {
    return $comments->map(function (Comment $comment) use($withReply) {
        return addCountsComment($comment, $withReply);
    });
}

function addCountsPost(Post $post, bool $withComments = false): Post {
    $post->liked = false;
    if (Auth::check()) {
        $post->liked = $post->likes->contains('user_id', Auth::id());
    }

    $post->likesCount = count($post->likes);
    $post->commentsCount = count($post->comments);

    if (Post::find($post->id)->views == null) {
        Post::find($post->id)->views()->create();
    }

    Post::find($post->id)->views->increment('count');
    $post->viewsCount = Post::find($post->id)->views->count;

    if ($withComments) {
        $post->comments = addCountsComments($post->comments);
    }

    return $post;
}

function addCountsPosts(Collection $posts, $withReply=false): Collection {
    return $posts->map(function ($post) use ($withReply) {
        return addCountsPost($post, $withReply=$withReply);
    });
}

function getTrendingPosts(int $limit) {
    $posts = Post::select('posts.*')
        ->selectRaw('
            (SELECT COUNT(*) FROM likes WHERE likes.likeable_id = posts.id AND likes.likeable_type = "App\\Models\\Post") 
            + 
            (SELECT COUNT(*) FROM comments WHERE comments.post_id = posts.id)
            AS total_count
        ')
        ->orderByDesc('total_count')
        ->take($limit)
        ->get();

    return $posts;
}
