@php
    function getSubPage() {
        $variables = explode('/', Request::path());
        array_shift($variables);
        return implode('/', $variables);
    }
@endphp

<x-layout>
    <div class="flex justify-between md:gap-8 pt-12 md:pt-16 mb-16">
        <x-left />
        <div class="w-full sm:w-full mx-auto px-4 mt-4 sm:mt-2">
            <div class="lg:w-full mx-auto">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <image
                            class="w-6 h-6 sm:w-8 sm:h-8 rounded-full"
                            src="{{ $post->user->image_url ? asset("/storage/icons/{$post->user->image_url}") : "/img/users.png" }}"
                            alt="{{ $post->user->image_url ? $post->user->image_url : "/img/users.png" }}"
                            />
                        <div>
                            <p class="font-semibold text-xs sm:text-base">{{ $post->user->name }}</p>
                            <p class="text-xs sm:text-sm text-gray-500">{{ $post->user->username }} • {{ $post->created_at->diffForHumans() }}</p>
                        </div>
                    </div>
                    <div class="flex my-4 py-1 px-2 rounded-md gap-2 items-center border bg-gray-100 border-gray-300 w-max">
                        <image
                            class="w-2 h-2 md:w-4 md:h-4 rounded-full"
                            src="{{ $post->corner->icon_url ? asset("/storage/icons/{$post->corner->icon_url}") : "/img/group.png" }}"
                            alt="{{ $post->corner->icon_url ? $post->corner->icon_url : "/img/group.png" }}"
                            />
                        <p class="text-xs lg:text-sm text-gray-500">{{ $post->corner->name }}</p>
                    </div>
                </div>
                <p class="mt-2 text-md md:text-base font-bold">{{ $post->title }}</p>
                <p class="mt-1 text-sm md:text-md">{{ $post->content }}</p>
                <div class="flex justify-between mt-2">
                    <div class="flex gap-2 sm:gap-3">
                        <div id="dislike#{{ $post->id }}" onclick="toggleLike('{{ $post->id }}')"
                            class="{{ $liked ?? false ? 'block' : 'hidden' }} text-gray-500 hover:text-gray-700 flex items-center gap-1 cursor-pointer border border-gray-400 bg-gray-200 px-2 py-1 rounded-lg">
                            <x-heroicon-s-heart class="w-4 h-4" />
                            <p class="text-xs sm:text-sm leading-tight">{{ intval($post->likes) + 1 }} <span
                                    class="hidden sm:inline">likes</span></p>
                        </div>
                        <div id="like#{{ $post->id }}" onclick="toggleLike('{{ $post->id }}')"
                            class="{{ $liked ?? false ? 'hidden' : 'block' }} text-gray-500 hover:text-gray-700 flex items-center gap-1 cursor-pointer border border-gray-400 bg-gray-200 px-2 py-1 rounded-lg">
                            <x-heroicon-o-heart class="w-4 h-4" />
                            <p class="text-xs sm:text-sm leading-tight">{{ $post->likes }} <span
                                    class="hidden sm:inline">likes</span></p>
                        </div>
                        <div class="flex items-center gap-1 text-gray-500 hover:text-gray-700 border border-gray-400 bg-gray-200 px-2 py-1 rounded-lg">
                            <x-heroicon-o-chat-bubble-left-right class="w-4 h-4" />
                            <p class="text-xs sm:text-sm leading-tight">{{ count($post->comments) }} <span
                                    class="hidden sm:inline">comments</span></p>
                        </div>
                        <div class="flex items-center gap-1 text-gray-500 hover:text-gray-700 border border-gray-400 bg-gray-200 px-2 py-1 rounded-lg">
                            <x-heroicon-s-chart-bar class="w-4 h-4" />
                            <p class="text-xs sm:text-sm leading-tight">{{ rand(0, 999) }} <span
                                    class="hidden sm:inline">views</span></p>
                        </div>
                    </div>
                    <div id="bookmarked#{{ $post->id }}" onclick="toggleBookmark('{{ $post->id }}')"
                        class="{{ $bookmark ?? false ? 'block' : 'hidden' }}">
                        <x-heroicon-s-bookmark class="w-4 h-4 cursor-pointer text-gray-500 hover:text-gray-700" />
                    </div>
                    <div id="bookmarking#{{ $post->id }}" onclick="toggleBookmark('{{ $post->id }}')"
                        class="{{ $bookmark ?? false ? 'hidden' : 'block' }}">
                        <x-heroicon-o-bookmark class="w-4 h-4 cursor-pointer text-gray-500 hover:text-gray-700" />
                    </div>
                </div>
                <x-form.comment :postId="$post->id" />
                <div class="space-y-4">
                    @foreach ($post->comments as $comment)
                    <x-comment
                        :$comment
                        :$post
                        replyId="comment#{{ $comment->id }}"
                        loadingId="loading#{{ $comment->id }}" />
                    <div id="loading#{{ $comment->id }}" class="hidden w-full">
                        <svg class="mx-auto animate-spin h-5 w-5 text-gray-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                            <path d="M4 12a8 8 0 0116 0" stroke="currentColor" stroke-width="4" fill="none"></path>
                        </svg>
                    </div>
                    <div id="comment#{{ $comment->id }}" class="hidden">
                        <div class="ml-8 space-y-4">
                            @foreach ($comment->replies as $reply)
                                <x-comment
                                :$post
                                :comment="$reply"
                                :hideReply="true"
                                />
                            @endforeach
                        </div>
                        <x-form.comment :postId="$post->id" :parentId="$comment->id" />
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <script>
            function toggleLike(image_url) {
                const likeButton = document.getElementById(`like#${image_url}`);
                const dislikeButton = document.getElementById(`dislike#${image_url}`);
    
                dislikeButton.classList.toggle("hidden");
                dislikeButton.classList.toggle("block");
                likeButton.classList.toggle("hidden");
                likeButton.classList.toggle("block");
            }
    
            function toggleBookmark(image_url) {
                const bookmarkingButton = document.getElementById(`bookmarking#${image_url}`);
                const bookmarkedButton = document.getElementById(`bookmarked#${image_url}`);
    
                bookmarkedButton.classList.toggle("hidden");
                bookmarkedButton.classList.toggle("block");
                bookmarkingButton.classList.toggle("hidden");
                bookmarkingButton.classList.toggle("block");
            }
        </script>
        <x-right />
    </div>
</x-layout>
