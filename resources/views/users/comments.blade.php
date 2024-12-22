<x-user.layout :$user>
    @if(count($comments) == 0)
        <div class="h-3/5 grid px-4 w-5/6 m-auto md:w-full">
            <div class="grid m-auto text-center">
                <x-heroicon-s-chat-bubble-bottom-center-text class="m-auto auto w-8 h-8 md:w-16 md:h-16 text-gray-400" />
                <h1 class="font-bold text-sm md:text-lg text-gray-500">There's none around here...</h1>
                <p class="text-sm md:text-md font-semibold text-gray-500">Hmm... maybe check your spellings or try different word</p>
            </div>
        </div>
    @else
        @foreach ($comments as $comment)
            <x-card
                :id="$comment->id"
                :postId="$comment->post_id"
                :commentId="$comment->id"
                :corner="$comment->corner->handle"
                :type="$comment->type"
                :author="$comment->user->name"
                :authorId="$comment->user->id"
                :authorUsername="$comment->user->username"
                :date="$comment->updated_at->format('j F Y')"
                :imageUrl="$comment->user->image_url"
                :title="$comment->post->title"
                :description="$comment->body"
                :likes="$comment->likesCount"
                :views="$comment->viewsCount"
                :comments="$comment->replies_count"
                :liked="$comment->liked"
                :bookmark="$comment->bookmarked" />
        @endforeach
    @endif
</x-user.layout>