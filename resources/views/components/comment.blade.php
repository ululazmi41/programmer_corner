@props([
    'post',
    'comment',
    'replyId' => null,
    'hideReply' => false,
])

<div>
    <div class="flex items-center gap-2">
        <a href="{{ route('users.show', ['username' => $comment->user->username]) }}">
            <image class="w-4 h-4 md:w-8 md:h-8 rounded-full"
            src="{{ $comment->user->image_url ? asset("/storage/icons/{$comment->user->image_url}") : '/img/user.png' }}"
            alt="{{ $comment->user->image_url ? $comment->user->image_url : '/img/user.png' }}" />
        </a>
        <div>
            <a href="{{ route('users.show', ['username' => $comment->user->username]) }}">
                <p class="text-xs lg:text-sm font-semibold">{{ $comment->user->name }}</p>
            </a>
            <p class="text-xs lg:text-sm text-gray-500">
                <a href="{{ route('users.show', ['username' => $comment->user->username]) }}">
                    {{ '@' }}{{ $comment->user->username }}
                </a>
                • {{ $comment->created_at->diffForHumans() }}
            </p>
        </div>
    </div>
    <p id="comment-{{ $comment->id }}-body" class="text-xs lg:text-sm mt-1">{{ $comment->body }}</p>
    <div class="flex justify-between mt-2">
        <div class="flex gap-2 sm:gap-3">
            <div id="comment-{{ $comment->id }}-dislike" onclick="toggleCommentLike('{{ $comment->id }}')"
                class="{{ $comment->liked ?? false ? 'block' : 'hidden' }} text-red-500 hover:text-red-700 flex items-center gap-1 cursor-pointer">
                <x-heroicon-s-heart class="w-4 h-4" />
                <p class="text-xs sm:text-sm leading-tight">{{ intval($comment->likesCount) + intval(!$comment->liked) }} <span
                        class="hidden sm:inline">likes</span></p>
            </div>
            <div id="comment-{{ $comment->id }}-like" onclick="toggleCommentLike('{{ $comment->id }}')"
                class="{{ $comment->liked ?? false ? 'hidden' : 'block' }} text-gray-500 hover:text-gray-700 flex items-center gap-1 cursor-pointer">
                <x-heroicon-o-heart class="w-4 h-4" />
                <p class="text-xs sm:text-sm leading-tight">{{ intval($comment->likesCount) - intval($comment->liked) }} <span
                        class="hidden sm:inline">likes</span></p>
            </div>
            @if ($hideReply == false)
                @if ($replyId != null)
                    <div
                        onclick="showReply(
                            '{{ $replyId }}',
                            'loading#{{ $comment->id }}',
                            'commentIcon#{{ $comment->id }}#outline',
                            'commentIcon#{{ $comment->id }}#solid',
                        )"
                        class="group flex items-center gap-1 text-gray-500 hover:text-gray-700 cursor-pointer ">
                        <x-heroicon-o-chat-bubble-left-right id="commentIcon#{{ $comment->id }}#outline" class="w-4 h-4 group-hover:hidden" />
                        <x-heroicon-s-chat-bubble-left-right id="commentIcon#{{ $comment->id }}#solid" class="w-4 h-4 hidden group-hover:block" />
                        <p class="text-xs sm:text-sm leading-tight">{{ count($comment->replies) }} <span
                                class="hidden sm:inline">comments</span></p>
                    </div>
                @else
                    <div class="flex items-center gap-1 text-gray-500 hover:text-gray-700 cursor-pointer ">
                        <x-heroicon-o-chat-bubble-left-right class="w-4 h-4" />
                        <p class="text-xs sm:text-sm leading-tight">{{ count($comment->replies) }} <span
                                class="hidden sm:inline">comments</span></p>
                    </div>
                @endif
            @endif
            <div class="flex items-center gap-1 text-gray-500 hover:text-gray-700">
                <x-heroicon-s-chart-bar class="w-4 h-4" />
                <p class="text-xs sm:text-sm leading-tight">{{ $comment->viewsCount }} <span
                        class="hidden sm:inline">views</span></p>
            </div>
            @auth
                @if ($comment->user_id == Auth::id())
                    <div class="relative inline-block text-left">
                        <input type="checkbox" id="comment-{{ $comment->id }}-dropdown-toggle" class="hidden peer" />
                        <label for="comment-{{ $comment->id }}-dropdown-toggle">
                            <x-heroicon-o-ellipsis-horizontal class="w-6 h-6 text-gray-400 cursor-pointer" />
                        </label>

                        <div id="comment-{{ $comment->id }}-dropdown-menu"
                            class="hidden peer-checked:block absolute right-0 z-10 mt-2 origin-top-right rounded-md bg-white shadow-lg ring-1 ring-black/5 focus:outline-none"
                            role="menu" aria-orientation="vertical" aria-labelledby="menu-button" tabindex="-1">
                            <div class="py-2 px-1 grid gap-2" role="none">
                                <form
                                    action="/comments/{{ $comment->id }}"
                                    method="POST"
                                    class="flex gap-2 items-center px-4 text-sm text-gray-500 hover:text-gray-700"
                                    role="menuitem" tabindex="-1" id="menu-item-1">
                                    @csrf
                                    @method("DELETE")
                                    <button type="submit">delete</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endif
            @endauth
        </div>
        <div id="bookmarked#{{ $comment->id }}" onclick="toggleCommentBookmark('{{ $comment->id }}', '{{ Auth::check() }}')"
            class="{{ $bookmark ?? false ? 'block' : 'hidden' }}">
            <x-heroicon-s-bookmark class="w-4 h-4 cursor-pointer text-gray-500 hover:text-gray-700" />
        </div>
        <div id="bookmarking#{{ $comment->id }}" onclick="toggleCommentBookmark('{{ $comment->id }}', '{{ Auth::check() }}')"
            class="{{ $bookmark ?? false ? 'hidden' : 'block' }}">
            <x-heroicon-o-bookmark class="w-4 h-4 cursor-pointer text-gray-500 hover:text-gray-700" />
        </div>
    </div>
    <div id="loading#{{ $comment->id }}" class="hidden w-full">
        <svg class="mx-auto animate-spin h-5 w-5 text-gray-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor">
            <path d="M4 12a8 8 0 0116 0" stroke="currentColor" stroke-width="4" fill="none"></path>
        </svg>
    </div>
    <div id="comment#{{ $comment->id }}" class="hidden">
        <div class="ml-4 md:ml-8 mt-4 space-y-4" id="comment-{{ $comment->id }}-replies">
            @foreach ($comment->replies as $reply)
                <x-comment
                :$post
                :comment="$reply"
                :hideReply="true"
                />
            @endforeach
        </div>
        <x-form.textarea name="body" id="comment-{{ $comment->id }}-reply-body" />
        <div class="flex mt-2">
            <button onclick="sendReply('{{ $post->id }}', 'reply-body', '{{ $comment->id }}')" class="text-sm lg:text-base bg-blue-500 rounded-lg py-1 px-3 lg:px-4 text-white ml-auto" type="submit">
                Submit
            </button>
        </div>
    </div>
    <script>
        document.addEventListener('click', () => {
            const dropdownToggle = document.getElementById('comment-{{ $comment->id }}-dropdown-toggle');
            const dropdownMenu = document.getElementById('comment-{{ $comment->id }}-dropdown-menu');

            if (dropdownMenu !== null) {
                if (!dropdownMenu.contains(event.target) && event.target !== dropdownToggle) {
                    dropdownToggle.checked = false;
                }
            }
        });

        function sendReply(postId, id, commentId) {
            const textarea = document.querySelector(`#comment-${commentId}-reply-body`);
            const formData = new FormData();
            formData.append("body", textarea.value);
            formData.append("post_id", postId);
            formData.append("parent_id", commentId);
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
                const RepliesList = document.querySelector(`#comment-${commentId}-replies`);
                RepliesList.innerHTML += element;
                textarea.value = "";
            });
        }

        function showLoading(loadingId) {
            const loading = document.getElementById(`${loadingId}`);
            loading.classList.remove('hidden');
        }

        function hideLoading(loadingId) {
            const loading = document.getElementById(`${loadingId}`);
            loading.classList.add('hidden');
        }

        function showReply(commentId, loadingId, outlineId, solidId) {
            const comment = document.getElementById(`${commentId}`);

            const outline = document.getElementById(outlineId);
            const solid = document.getElementById(solidId);
            outline.classList.toggle('hidden');
            solid.classList.toggle('hidden');

            if (comment.classList.contains('hidden')) {
                showLoading(loadingId);

                setTimeout(() => {
                    hideLoading(loadingId);

                    comment.classList.toggle('hidden');
                }, 300);
            } else {
                comment.classList.toggle('hidden');
            }
        }

        function sendCommentLike(commentId) {
            let formData = new FormData();
            formData.append("type", 'comment');
            formData.append("id", commentId);

            fetch('/likes', {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: formData,
            });
        }

        function toggleCommentLike(commentId) {
            sendCommentLike(commentId);
            const likeButton = document.getElementById(`comment-${commentId}-like`);
            const dislikeButton = document.getElementById(`comment-${commentId}-dislike`);

            dislikeButton.classList.toggle("hidden");
            dislikeButton.classList.toggle("block");
            likeButton.classList.toggle("hidden");
            likeButton.classList.toggle("block");
        }

        function sendCommentBookmark(id) {
            let formData = new FormData();
            formData.append("type", 'comment');
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

        function toggleCommentBookmark(id, loggedIn) {
            if (!loggedIn) {
                return;
            }
            sendCommentBookmark(id, loggedIn);

            const bookmarkingButton = document.getElementById(`bookmarking#${id}`);
            const bookmarkedButton = document.getElementById(`bookmarked#${id}`);

            bookmarkedButton.classList.toggle("hidden");
            bookmarkedButton.classList.toggle("block");
            bookmarkingButton.classList.toggle("hidden");
            bookmarkingButton.classList.toggle("block");
        }
    </script>
</div>
