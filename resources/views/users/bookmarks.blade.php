<x-user.layout :$user>
    @if(empty($bookmarks))
        <div class="h-3/5 grid px-4 w-5/6 m-auto md:w-full">
            <div class="grid m-auto text-center">
                <x-heroicon-s-chat-bubble-bottom-center-text class="m-auto auto w-8 h-8 md:w-16 md:h-16 text-gray-400" />
                <h1 class="font-bold text-sm md:text-lg text-gray-500">There's none around here...</h1>
                <p class="text-sm md:text-md font-semibold text-gray-500">Hmm... maybe check your spellings or try different word</p>
            </div>
        </div>
    @else
        <p class="my-2 px-2 py-1 w-max rounded-lg text-xs sm:text-sm lg:text-md border border-gray-500 bg-gray-200 text-gray-700">
            Your bookmarks are private.
        </p>
        @foreach ($bookmarks as $index => $bookmark)
            @if ($bookmark->type == App\Enums\ContentType::POST)
                <x-card
                    :id="$index"
                    :postId="$bookmark->id"
                    :corner="$bookmark->corner->handle"
                    :type="$bookmark->type"
                    :author="$bookmark->user->name"
                    :authorId="$bookmark->user->id"
                    :authorUsername="$bookmark->user->username"
                    :date="$bookmark->created_at->format('j F Y')"
                    :imageUrl="$bookmark->corner->icon_url"
                    :title="$bookmark->title"
                    :description="$bookmark->content"
                    :likes="$bookmark->likesCount"
                    :views="$bookmark->viewsCount"
                    :comments="$bookmark->commentsCount"
                    :liked="$bookmark->liked"
                    :bookmark="true" />
            @elseif ($bookmark->type == App\Enums\ContentType::COMMENT)
                <x-card
                    :id="$index"
                    :postId="$bookmark->post_id"
                    :commentId="$bookmark->id"
                    :corner="$bookmark->corner->handle"
                    :type="$bookmark->type"
                    :author="$bookmark->user->name"
                    :authorId="$bookmark->user->id"
                    :authorUsername="$bookmark->user->username"
                    :date="$bookmark->created_at->format('j F Y')"
                    :imageUrl="$bookmark->user->image_url"
                    :title="$bookmark->post->title"
                    :description="$bookmark->body"
                    :likes="$bookmark->likesCount"
                    :views="$bookmark->viewsCount"
                    :comments="$bookmark->replies_count"
                    :liked="$bookmark->liked"
                    :bookmark="true" />
            @endif
        @endforeach
    @endif
</x-user.layout>