<div class="w-64 hidden lg:block h-full sticky top-20">
    <h3 class="mb-2 text-lg font-bold text-gray-500">Trending Posts</h3>
    <ul class="flex flex-col gap-2">
        @foreach ($trendingPosts as $post)
            <li>
                <x-trending-card-dynamic
                :id="$post->id"
                :title="$post->title"
                :description="$post->content"
                :likes="$post->likesCount"
                :comments="$post->commentsCount"
                :imageUrl="$post->corner->icon_url"
                />
            </li>
        @endforeach
    </ul>
</div>