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
        <div class="w-full md:w-3/5 mx-auto px-4 mt-4 sm:mt-2">
            <div class="lg:w-full mx-auto">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <a href="{{ route('users.show', ['username' => $post->user->username]) }}">
                            <image
                            class="w-6 h-6 sm:w-8 sm:h-8 rounded-full"
                            src="{{ $post->user->image_url ? asset("/storage/icons/{$post->user->image_url}") : "/img/user.png" }}"
                            alt="{{ $post->user->image_url ? $post->user->image_url : "/img/user.png" }}"
                            />
                        </a>
                        <div>
                            <a class="block w-max" href="{{ route('users.show', ['username' => $post->user->username]) }}">
                                <p class="font-semibold text-xs sm:text-base">{{ $post->user->name }}</p>
                            </a>
                            <p class="text-xs sm:text-sm text-gray-500">
                                <a href="{{ route('users.show', ['username' => $post->user->username]) }}">
                                    {{ $post->user->username }}
                                </a> • {{ $post->created_at->diffForHumans() }}
                            </p>
                        </div>
                    </div>
                    <div class="my-4">
                        <a href="{{ route('corners.show', ['handle' => $post->corner->handle]) }}">
                            <div class="flex py-1 px-2 rounded-md gap-2 items-center border bg-gray-100 hover:bg-gray-200 border-gray-300 w-max">
                                <image
                                class="w-2 h-2 md:w-4 md:h-4 rounded-full"
                                src="{{ $post->corner->icon_url ? asset("/storage/icons/{$post->corner->icon_url}") : "/img/group.png" }}"
                                alt="{{ $post->corner->icon_url ? $post->corner->icon_url : "/img/group.png" }}"
                                />
                                <p class="text-xs lg:text-sm text-gray-500 hover:text-gray-600">{{ $post->corner->name }}</p>
                            </div>
                        </a>
                    </div>
                </div>
                <p class="mt-2 text-md md:text-base font-bold">{{ $post->title }}</p>
                <p class="mt-1 text-sm md:text-md">{!! nl2br(e($post->content)) !!}</p>
                <div class="flex justify-between mt-2">
                    <div class="flex gap-2 sm:gap-3">
                        <div id="dislike#{{ $post->id }}" onclick="toggleLike('{{ $post->id }}')"
                            class="{{ $post->liked ?? false ? 'block' : 'hidden' }} text-gray-500 hover:text-gray-700 flex items-center gap-1 cursor-pointer border border-gray-400 bg-gray-200 px-2 py-1 rounded-lg">
                            <x-heroicon-s-heart class="w-4 h-4" />
                            <p class="text-xs sm:text-sm leading-tight">{{ intval($post->likesCount) + intval(!$post->liked)}} <span
                                    class="hidden sm:inline">likes</span></p>
                        </div>
                        <div id="like#{{ $post->id }}" onclick="toggleLike('{{ $post->id }}')"
                            class="{{ $post->liked ?? false ? 'hidden' : 'block' }} text-gray-500 hover:text-gray-700 flex items-center gap-1 cursor-pointer border border-gray-400 bg-gray-200 px-2 py-1 rounded-lg">
                            <x-heroicon-o-heart class="w-4 h-4" />
                            <p class="text-xs sm:text-sm leading-tight">{{ $post->likesCount - intval($post->liked)  }} <span
                                    class="hidden sm:inline">likes</span></p>
                        </div>
                        <div class="flex items-center gap-1 text-gray-500 hover:text-gray-700 border border-gray-400 bg-gray-200 px-2 py-1 rounded-lg">
                            <x-heroicon-o-chat-bubble-left-right class="w-4 h-4" />
                            <p class="text-xs sm:text-sm leading-tight">{{ count($post->comments) }} <span
                                    class="hidden sm:inline">comments</span></p>
                        </div>
                        <div class="flex items-center gap-1 text-gray-500 hover:text-gray-700 border border-gray-400 bg-gray-200 px-2 py-1 rounded-lg">
                            <x-heroicon-s-chart-bar class="w-4 h-4" />
                            <p class="text-xs sm:text-sm leading-tight">{{ $post->views->count }} <span
                                    class="hidden sm:inline">views</span></p>
                        </div>
                    </div>
                    <div id="bookmarked#{{ $post->id }}" onclick="togglePostBookmark('{{ $post->id }}', {{ Auth::check() }})"
                        class="{{ $bookmark ?? false ? 'block' : 'hidden' }}">
                        <x-heroicon-s-bookmark class="w-4 h-4 cursor-pointer text-gray-500 hover:text-gray-700" />
                    </div>
                    <div id="bookmarking#{{ $post->id }}" onclick="togglePostBookmark('{{ $post->id }}', {{ Auth::check() }})"
                        class="{{ $bookmark ?? false ? 'hidden' : 'block' }}">
                        <x-heroicon-o-bookmark class="w-4 h-4 cursor-pointer text-gray-500 hover:text-gray-700" />
                    </div>
                </div>
                <x-form.textarea name="body" id="comment-body" />
                <div class="flex mt-2">
                    <button onclick="sendComment('{{ $post->id }}', 'comment-body')" class="text-sm lg:text-base bg-blue-500 rounded-lg py-1 px-3 lg:px-4 text-white ml-auto" type="submit">
                        Submit
                    </button>
                </div>
                <div class="space-y-4" id="comments">
                    @foreach ($post->comments as $comment)
                        <x-comment
                            :$post
                            :$comment
                            replyId="comment#{{ $comment->id }}" />
                    @endforeach
                </div>
            </div>
        </div>

        <script>
            function sendComment(postId, id) {
                const textarea = document.querySelector(`#${id}`);
                const formData = new FormData();
                formData.append("body", textarea.value);
                formData.append("post_id", postId);
                
                textarea.value = "";

                fetch('/comments', {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: formData,
                })
                .then(response => response.json())
                .then(data => {
                    const element = data.commentHtml;
                    const commentsList = document.querySelector('#comments');
                    commentsList.insertAdjacentHTML("afterbegin", element);
                    textarea.value = "";
                });
            }

            function sendLike(postId) {
                let formData = new FormData();
                formData.append("type", 'post');
                formData.append("id", postId);

                fetch('/likes', {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: formData,
                });
            }

            function toggleLike(postId) {
                sendLike(postId);

                const likeButton = document.getElementById(`like#${postId}`);
                const dislikeButton = document.getElementById(`dislike#${postId}`);
    
                dislikeButton.classList.toggle("hidden");
                dislikeButton.classList.toggle("block");
                likeButton.classList.toggle("hidden");
                likeButton.classList.toggle("block");
            }

            function sendPostBookmark(id) {
                let formData = new FormData();
                formData.append("type", 'post');
                formData.append("id", id);

                fetch('/bookmarks', {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: formData,
                });
            }

            function togglePostBookmark(id, loggedIn) {
                if (!loggedIn) {
                    return;
                }
                sendPostBookmark(id, loggedIn);

                const bookmarkingButton = document.getElementById(`bookmarking#${id}`);
                const bookmarkedButton = document.getElementById(`bookmarked#${id}`);

                bookmarkedButton.classList.toggle("hidden");
                bookmarkedButton.classList.toggle("block");
                bookmarkingButton.classList.toggle("hidden");
                bookmarkingButton.classList.toggle("block");
            }
        </script>
        <x-trending />
    </div>
</x-layout>
