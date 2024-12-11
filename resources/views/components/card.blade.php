<div class="hover:bg-gray-100 px-4 pt-4">
    <div class="grid grid-cols-[max-content_1fr] gap-2">
        <a href="/communities">
            <Image class="my-auto w-8 h-8 sm:w-10 sm:h-w-10" src="/img/{{ $imageUrl }}" alt="{{ $imageUrl }}" />
        </a>
        <div>
            @if ($featured ?? false)
                <div class="flex items-center gap-1">
                    <x-heroicon-s-tag class="w-2 h-2 text-gray-900" />
                    <p class="text-xs leading-tight text-gray-900">featured</p>
                </div>
            @endif
            <div class="text-xs sm:text-md font-bold leading-tight line-clamp-2">What's the cheapest way to host a python script?</div>
            <div class="text-xs text-gray-400">{{ $author }} • {{ $date }}</div>
        </div>
        <div class="hidden sm:block"></div>
        <div class="col-span-2 sm:col-span-1">
            <a href="/">
                <p class="leading-tight text-xs md:text-sm line-clamp-3">
                    {{ $description }}
                </p>
            </a>
            <div class="flex justify-between mt-2">
                <div class="flex gap-4 sm:gap-3">
                    <div id="dislike#{{ $imageUrl }}" onclick="toggleLike('{{ $imageUrl }}')"
                        class="{{ $liked ? 'block' : 'hidden' }} text-red-500 hover:text-red-500 flex items-center gap-1 cursor-pointer">
                        <x-heroicon-s-heart class="w-4 h-4" />
                        <p class="text-xs sm:text-sm leading-tight">{{ intval($likes) + 1 }} <span
                                class="hidden sm:inline">likes</span></p>
                    </div>
                    <div id="like#{{ $imageUrl }}" onclick="toggleLike('{{ $imageUrl }}')"
                        class="{{ $liked ? 'hidden' : 'block' }} text-gray-500 hover:text-gray-500 flex items-center gap-1 cursor-pointer">
                        <x-heroicon-o-heart class="w-4 h-4" />
                        <p class="text-xs sm:text-sm leading-tight">{{ $likes }} <span
                                class="hidden sm:inline">likes</span></p>
                    </div>
                    <div class="flex items-center gap-1 text-gray-500 hover:text-gray-700 cursor-pointer">
                        <x-heroicon-o-chat-bubble-left-right class="w-4 h-4" />
                        <p class="text-xs sm:text-sm leading-tight">{{ $comments }} <span
                                class="hidden sm:inline">comments</span></p>
                    </div>
                    <div class="flex items-center gap-1 text-gray-500 hover:text-gray-700">
                        <x-heroicon-s-chart-bar class="w-4 h-4" />
                        <p class="text-xs sm:text-sm leading-tight">{{ $views }} <span
                                class="hidden sm:inline">views</span></p>
                    </div>
                </div>
                <div id="bookmarked#{{ $imageUrl }}" onclick="toggleBookmark('{{ $imageUrl }}')"
                    class="{{ $bookmark ? 'block' : 'hidden' }}">
                    <x-heroicon-s-bookmark class="w-4 h-4 cursor-pointer text-gray-500 hover:text-gray-700" />
                </div>
                <div id="bookmarking#{{ $imageUrl }}" onclick="toggleBookmark('{{ $imageUrl }}')"
                    class="{{ $bookmark ? 'hidden' : 'block' }}">
                    <x-heroicon-o-bookmark class="w-4 h-4 cursor-pointer text-gray-500 hover:text-gray-700" />
                </div>
            </div>
        </div>
    </div>
    <div class="mt-2 bg-gray-300 h-px w-full"></div>

    <script>
        function toggleLike(imageUrl) {
            const likeButton = document.getElementById(`like#${imageUrl}`);
            const dislikeButton = document.getElementById(`dislike#${imageUrl}`);

            dislikeButton.classList.toggle("hidden");
            dislikeButton.classList.toggle("block");
            likeButton.classList.toggle("hidden");
            likeButton.classList.toggle("block");
        }

        function toggleBookmark(imageUrl) {
            const bookmarkingButton = document.getElementById(`bookmarking#${imageUrl}`);
            const bookmarkedButton = document.getElementById(`bookmarked#${imageUrl}`);

            bookmarkedButton.classList.toggle("hidden");
            bookmarkedButton.classList.toggle("block");
            bookmarkingButton.classList.toggle("hidden");
            bookmarkingButton.classList.toggle("block");
        }
    </script>
</div>