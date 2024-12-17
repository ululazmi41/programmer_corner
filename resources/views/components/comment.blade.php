@props([
    'comment',
    'post',
    'replyId' => null,
    'loadingId' => null,
    'hideReply' => false,
])

<div>
    <div class="flex items-center gap-2">
        <image class="w-4 h-4 md:w-8 md:h-8 rounded-full"
            src="{{ $comment->user->image_url ? asset("/storage/icons/{$comment->user->image_url}") : '/img/user.png' }}"
            alt="{{ $comment->user->image_url ? $comment->user->image_url : '/img/user.png' }}" />
        <div>
            <p class="text-xs lg:text-sm font-semibold">{{ $comment->user->name }}</p>
            <p class="text-xs lg:text-sm text-gray-500">{{ '@' }}{{ $comment->user->username }} •
                {{ $comment->created_at->diffForHumans() }}</p>
        </div>
    </div>
    <p class="text-xs lg:text-sm mt-1">{{ $comment->body }}</p>
    <div class="flex justify-between mt-2">
        <div class="flex gap-2 sm:gap-3">
            <div id="comment-{{ $comment->id }}-dislike" onclick="toggleCommentLike('comment-{{ $comment->id }}')"
                class="{{ $liked ?? false ? 'block' : 'hidden' }} text-red-500 hover:text-red-700 flex items-center gap-1 cursor-pointer">
                <x-heroicon-s-heart class="w-4 h-4" />
                <p class="text-xs sm:text-sm leading-tight">{{ intval($comment->likes) + 1 }} <span
                        class="hidden sm:inline">likes</span></p>
            </div>
            <div id="comment-{{ $comment->id }}-like" onclick="toggleCommentLike('comment-{{ $comment->id }}')"
                class="{{ $liked ?? false ? 'hidden' : 'block' }} text-gray-500 hover:text-gray-700 flex items-center gap-1 cursor-pointer">
                <x-heroicon-o-heart class="w-4 h-4" />
                <p class="text-xs sm:text-sm leading-tight">{{ $comment->likes }} <span
                        class="hidden sm:inline">likes</span></p>
            </div>
            @if ($hideReply == false)
                @if ($replyId != null)
                    <div
                        onclick="showReply(
                            '{{ $replyId }}',
                            '{{ $loadingId }}',
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
                <p class="text-xs sm:text-sm leading-tight">{{ rand(0, 999) }} <span
                        class="hidden sm:inline">views</span></p>
            </div>
        </div>
        <div id="bookmarked#{{ $comment->id }}" onclick="toggleBookmark('{{ $comment->id }}')"
            class="{{ $bookmark ?? false ? 'block' : 'hidden' }}">
            <x-heroicon-s-bookmark class="w-4 h-4 cursor-pointer text-gray-500 hover:text-gray-700" />
        </div>
        <div id="bookmarking#{{ $comment->id }}" onclick="toggleBookmark('{{ $comment->id }}')"
            class="{{ $bookmark ?? false ? 'hidden' : 'block' }}">
            <x-heroicon-o-bookmark class="w-4 h-4 cursor-pointer text-gray-500 hover:text-gray-700" />
        </div>
    </div>
    <script>
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

        function toggleCommentLike(baseId) {
            const likeButton = document.getElementById(`${baseId}-like`);
            const dislikeButton = document.getElementById(`${baseId}-dislike`);

            dislikeButton.classList.toggle("hidden");
            dislikeButton.classList.toggle("block");
            likeButton.classList.toggle("hidden");
            likeButton.classList.toggle("block");
        }
    </script>
</div>
