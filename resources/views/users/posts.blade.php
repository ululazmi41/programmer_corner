<x-user.layout :$user>
    @if(count($posts) == 0)
        <div class="h-3/5 grid px-4 w-5/6 m-auto md:w-full">
            <div class="grid m-auto text-center">
                <x-heroicon-s-chat-bubble-bottom-center-text class="m-auto auto w-8 h-8 md:w-16 md:h-16 text-gray-400" />
                <h1 class="font-bold text-sm md:text-lg text-gray-500">There's none around here...</h1>
                <p class="text-sm md:text-md font-semibold text-gray-500">Hmm... maybe check your spellings or try different word</p>
            </div>
        </div>
    @else
        @foreach ($posts as $post)
            <x-card
                :id="$post->id"
                :postId="$post->id"
                :corner="$post->handle"
                :type="\App\Enums\ContentType::POST"
                :author="$post->user->name"
                :authorId="$post->user->id"
                :authorUsername="$post->user->username"
                :date="$post->updated_at->format('j F Y')"
                :imageUrl="$post->user->image_url"
                :title="$post->title"
                :description="$post->content"
                :likes="$post->likesCount"
                :views="$post->viewsCount"
                :comments="$post->commentsCount"
                :liked="$post->liked"
                :bookmark="$post->bookmarked" />
        @endforeach
    @endif
</x-user.layout>