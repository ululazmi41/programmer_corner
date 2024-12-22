<x-user.layout :$user>
    @if(count($contents) == 0)
        <div class="h-3/5 grid px-4 w-5/6 m-auto md:w-full">
            <div class="grid m-auto text-center">
                <x-heroicon-s-chat-bubble-bottom-center-text class="m-auto auto w-8 h-8 md:w-16 md:h-16 text-gray-400" />
                <h1 class="font-bold text-sm md:text-lg text-gray-500">There's none around here...</h1>
                <p class="text-sm md:text-md font-semibold text-gray-500">Hmm... maybe check your spellings or try different word</p>
            </div>
        </div>
    @else
        @foreach ($contents as $index => $content)
            @if ($content->type == App\Enums\ContentType::POST)
                <x-card
                    :id="$index"
                    :postId="$content->id"
                    :corner="$content->corner->handle"
                    :type="$content->type"
                    :author="$content->user->name"
                    :authorId="$content->user->id"
                    :authorUsername="$content->user->username"
                    :date="$content->updated_at->format('j F Y')"
                    :imageUrl="$content->corner->icon_url"
                    :title="$content->title"
                    :description="$content->content"
                    :likes="$content->likesCount"
                    :views="$content->viewsCount"
                    :comments="$content->commentsCount"
                    :liked="$content->liked"
                    :bookmark="$content->bookmarked" />
            @elseif ($content->type == App\Enums\ContentType::COMMENT)
                <x-card
                    :id="$index"
                    :postId="$content->post_id"
                    :commentId="$content->id"
                    :corner="$content->corner->handle"
                    :type="$content->type"
                    :author="$content->user->name"
                    :authorId="$content->user->id"
                    :authorUsername="$content->user->username"
                    :date="$content->updated_at->format('j F Y')"
                    :imageUrl="$content->user->image_url"
                    :title="$content->post->title"
                    :description="$content->body"
                    :likes="$content->likesCount"
                    :views="$content->viewsCount"
                    :comments="$content->replies_count"
                    :liked="$content->liked"
                    :bookmark="$content->bookmarked" />
            @endif
        @endforeach
    @endif
</x-user.layout>