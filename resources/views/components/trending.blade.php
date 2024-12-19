<div class="w-64 hidden lg:block h-full sticky top-20">
    <h3 class="mb-2 text-lg font-bold text-gray-500">Trending Posts</h3>
    <ul class="flex flex-col gap-2">
        <li>
            <x-trending-card
            title="Go 1.23.4 is released"
            description="After downloading a binary..."
            likes="13.9K"
            comments="7.1K"
            imageUrl="go.png"
            />
        </li>
        <li>
            <x-trending-card
            title="Rust call for testing"
            description="We’ve been hard at work..."
            likes="92.8K"
            comments="43,3K"
            imageUrl="rust.png"
            />
        </li>
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