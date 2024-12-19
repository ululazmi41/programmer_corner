<?php

namespace App\Helpers;

use App\Models\Post;

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
