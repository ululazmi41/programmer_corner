@props([
    'role' => null,
    'type' => null,
    'id',
    'postId',
    'commentId' => null,
    'status' => null,
    'corner' => null,
    'author',
    'authorId',
    'authorUsername',
    'date',
    'imageUrl',
    'title',
    'description',
    'likes',
    'views',
    'comments',
    'liked',
    'bookmark',
])

@php
    $contentId = '';
    if ($type == \App\Enums\ContentType::POST) {
        $contentId = $postId;
    } else if ($type == \App\Enums\ContentType::COMMENT) {
        $contentId = $commentId;
    } else {
        $contentId = -1;
    }
    $deleteAction = '';
    if ($type == \App\Enums\ContentType::POST) {
        $deleteAction = route('posts.destroy', ['id' => $id]);
    } else if ($type == \App\Enums\ContentType::COMMENT) {
        $deleteAction = route('comments.destroy', ['id' => $id]);
    } else {
        $deleteAction = $type;
    }
@endphp

<div class="hover:bg-gray-100 px-4 pt-4">
    @if ($status ?? false)
        @if ($status == \App\Enums\UserOverview::POST)
            {{-- Do nothing --}}
        @elseif ($status === \App\Enums\UserOverview::COMMENT)
            <h1 class="text-xs text-gray-400 leading-tight">Commented on this post</h1>
        @endif
    @endif
    <div class="grid grid-cols-[max-content_1fr] gap-2 mt-1">
        <a class="leading-3 self-end" href="{{ route('users.show', ['username' => $authorUsername]) }}" class="m-auto">
            <Image class="my-auto w-8 h-8 sm:w-10 sm:h-10 rounded-full" src="{{ $imageUrl ? asset("storage/icons/" . $imageUrl) : "/img/user.png" }}" alt="{{ $imageUrl ? $imageUrl : "image icon" }}" />
        </a>
        <div class="self-center">
            @if ($featured ?? false)
                <div class="flex items-center gap-1">
                    <x-heroicon-s-tag class="w-2 h-2 text-gray-900" />
                    <p class="text-xs leading-tight text-gray-900">featured</p>
                </div>
            @endif
            @if ($corner)
                <a
                    class="text-gray-500 text-xs"
                    href="{{ route('corners.show', ['handle' => $corner]) }}">
                    ~{{ $corner }}
                </a>
            @endif
            <a href="/posts/{{ $postId ? $postId : '' }}">
                @if ($type == \App\Enums\ContentType::POST)
                    <div class="text-xs sm:text-md font-bold leading-tight line-clamp-2">{!! $title !!}</div>
                @elseif ($type === \App\Enums\ContentType::COMMENT)
                    <div class="text-xs sm:text-md font-bold leading-tight line-clamp-2">{!! $author !!}</div>
                @endif
            </a>
            <div class="text-xs text-gray-400">
                <a class="text hover:text-gray-700" href="{{ route('users.show', ['username' => $authorUsername]) }}">
                    {{ $author }}
                </a>
                • {{ $date }}</div>
        </div>
        <div class="hidden sm:block"></div>
        <div class="col-span-2 sm:col-span-1">
            <a href="/posts/{{ $postId ? $postId : '' }}">
                <p class="leading-tight text-xs md:text-sm line-clamp-3">
                    {!! $description !!}
                </p>
            </a>
            <div class="flex justify-between mt-2">
                <div class="flex gap-4 sm:gap-3">
                    @auth
                        <div id="{{ $type }}-{{ $id }}-dislike" onclick="toggleLike('{{ $id }}', '{{ $contentId }}', '{{ $type }}', {{ Auth::check() }})"
                            class="{{ $liked ? 'block' : 'hidden' }} text-red-500 hover:text-red-500 flex items-center gap-1 cursor-pointer">
                            <x-heroicon-s-heart class="w-4 h-4" />
                            <p class="text-xs sm:text-sm leading-tight">{{ intval($likes) + intval(!$liked) }} 
                                <span class="hidden sm:inline">likes</span
                            ></p>
                        </div>
                        <div id="{{ $type }}-{{ $id }}-like" onclick="toggleLike('{{ $id }}', '{{ $contentId }}', '{{ $type }}', {{ Auth::check() }})"
                            class="{{ $liked ? 'hidden' : 'block' }} text-gray-500 hover:text-gray-500 flex items-center gap-1 cursor-pointer">
                            <x-heroicon-o-heart class="w-4 h-4" />
                            <p class="text-xs sm:text-sm leading-tight">{{ intval($likes) - intval($liked) }}
                                <span class="hidden sm:inline">likes</span>
                            </p>
                        </div>
                    @endauth
                    @guest
                        <a href="{{ route('login') }}">
                            <div class="text-gray-500 hover:text-gray-500 flex items-center gap-1 cursor-pointer">
                                <x-heroicon-o-heart class="w-4 h-4" />
                                <p class="text-xs sm:text-sm leading-tight">{{ intval($likes) - intval($liked) }}
                                    <span class="hidden sm:inline">likes</span>
                                </p>
                            </div>
                        </a>
                    @endguest
                    <div class="flex items-center gap-1 text-gray-500 hover:text-gray-700">
                        <x-heroicon-o-chat-bubble-left-right class="w-4 h-4" />
                        <p class="text-xs sm:text-sm leading-tight">{{ $comments }} <span
                                class="hidden sm:inline">comments</span></p>
                    </div>
                    <div class="flex items-center gap-1 text-gray-500 hover:text-gray-700">
                        <x-heroicon-s-chart-bar class="w-4 h-4" />
                        <p class="text-xs sm:text-sm leading-tight">{{ $views }} <span
                                class="hidden sm:inline">views</span></p>
                    </div>
                    @auth
                        @if ($authorId == Auth::id() || $role == 'owner')
                            <div class="relative inline-block text-left">
                                <input type="checkbox" id="card-{{ $id }}-dropdown-toggle" class="hidden peer" />
                                <label for="card-{{ $id }}-dropdown-toggle">
                                    <x-heroicon-o-ellipsis-horizontal class="w-6 h-6 text-gray-400 hover:text-gray-700 cursor-pointer" />
                                </label>

                                <div id="card-{{ $id }}-dropdown-menu"
                                    class="hidden peer-checked:block absolute right-0 z-10 mt-2 origin-top-right rounded-md bg-white shadow-lg ring-1 ring-black/5 focus:outline-none"
                                    role="menu" aria-orientation="vertical" aria-labelledby="menu-button" tabindex="-1">
                                    <div class="py-2 px-1 grid gap-2" role="none">
                                        <form
                                            action="{{ $deleteAction }}"
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
                @auth
                    <div id="bookmarked#{{ $id }}" onclick="toggleBookmark('{{ $id }}', '{{ $contentId }}', '{{ $type }}', {{ Auth::check() }})"
                        class="{{ $bookmark ? 'block' : 'hidden' }}">
                        <x-heroicon-s-bookmark class="w-4 h-4 cursor-pointer text-gray-500 hover:text-gray-700" />
                    </div>
                    <div id="bookmarking#{{ $id }}" onclick="toggleBookmark('{{ $id }}', '{{ $contentId }}', '{{ $type }}', {{ Auth::check() }})"
                        class="{{ $bookmark ? 'hidden' : 'block' }}">
                        <x-heroicon-o-bookmark class="w-4 h-4 cursor-pointer text-gray-500 hover:text-gray-700" />
                    </div>
                @endauth
            </div>
        </div>
    </div>
    <div class="mt-2 bg-gray-300 h-px w-full"></div>

    <script>
        document.addEventListener('click', () => {
            const dropdownToggle = document.getElementById('card-{{ $id }}-dropdown-toggle');
            const dropdownMenu = document.getElementById('card-{{ $id }}-dropdown-menu');

            if (dropdownMenu !== null) {
                if (!dropdownMenu.contains(event.target) && event.target !== dropdownToggle) {
                    dropdownToggle.checked = false;
                }
            }
        });

        function sendLike(id, type) {
            let formData = new FormData();
            formData.append("type", type);
            formData.append("id", id);

            fetch('/likes', {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: formData,
            })
            .then(response => response.json())
            .then(data => console.log(data));
        }

        function toggleLike(id, likableId, type, loggedIn) {
            if (!loggedIn) {
                return;
            }
            sendLike(likableId, type);
            const likeButton = document.getElementById(`${type}-${id}-like`);
            const dislikeButton = document.getElementById(`${type}-${id}-dislike`);

            dislikeButton.classList.toggle("hidden");
            dislikeButton.classList.toggle("block");
            likeButton.classList.toggle("hidden");
            likeButton.classList.toggle("block");
        }

        function sendBookmark(id, type) {
            let formData = new FormData();
            formData.append("type", type);
            formData.append("id", id);

            fetch('/bookmarks', {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: formData,
            })
            .then(response => response.json())
            .then(data => console.log(data));
        }

        function toggleBookmark(id, contentId, type, loggedIn) {
            if (!loggedIn) {
                return;
            }
            sendBookmark(contentId, type, loggedIn);

            const bookmarkingButton = document.getElementById(`bookmarking#${id}`);
            const bookmarkedButton = document.getElementById(`bookmarked#${id}`);

            bookmarkedButton.classList.toggle("hidden");
            bookmarkedButton.classList.toggle("block");
            bookmarkingButton.classList.toggle("hidden");
            bookmarkingButton.classList.toggle("block");
        }
    </script>
</div>
