@props(['user'])

@php
    function getUserPage() {
        $variables = explode('/', Request::path());
        return join('/', array_slice($variables, 0, 2));
    }

    function getSubPage() {
        $variables = explode('/', Request::path());
        if (count($variables) > 2) {
            return $variables[2];
        }
        return '';
    }
@endphp

<x-layout>
    <div class="flex justify-between md:gap-4 pt-4 md:pt-16">
        <x-left />
        <div class="w-full md:w-3/5 py-8 px-4 md:p-0 md:pb-4">
            <image id="icon" class="w-16 h-16 rounded-full" src="{{ $user["image_url"] ? asset('storage/icons/' . $user["image_url"]) : "/img/user.png" }}" alt="profile picture" />
            <div class="flex justify-between">
                <div>
                    <p class="font-bold text-xl leading-tight">{{ $user["name"] }}</p>
                    <p class="text-gray-400 leading-tight">{{ '@' }}{{ $user["username"] }}</p>
                </div>
                @auth
                    @if (Auth::id() !== $user->id)
                        <button
                            id="follow"
                            onclick="follow('{{ $user->id }}', '{{ $user->username }}')"
                            class="{{ $user->followers->contains('id', Auth::id()) ? "hidden" : "" }} h-max text-sm font-semibold lg:text-base bg-blue-500 hover:bg-blue-400 transition transform duration-100 rounded-2xl py-1 px-3 lg:px-4 text-white ml-auto"
                        >+ follow</button>
                        <button
                            id="unfollow"
                            onclick="unfollow('{{ $user->id }}', '{{ $user->username }}')"
                            class="{{ $user->followers->contains('id', Auth::id()) ? "" : "hidden" }} h-max text-sm font-semibold lg:text-base bg-black/40 hover:bg-black/30 transition transform duration-100 rounded-2xl py-1 px-3 lg:px-4 text-white ml-auto"
                        >✓ following</button>
                    @endif
                @endauth
                @guest
                    <a href="{{ route('login') }}">
                        <button
                            class="h-max text-sm font-semibold lg:text-base bg-blue-500 hover:bg-blue-400 transition transform duration-100 rounded-2xl py-1 px-3 lg:px-4 text-white ml-auto"
                        >+ follow</button>
                    </a>
                @endguest
            </div>
            <div class="flex gap-2">
                <a href="{{ route('user.following', ['username' => $user->username]) }}">
                    <p class="text-gray-400"><span class="text-black font-semibold">{{ count($user->following) }}</span> following</p>
                </a>
                <a href="{{ route('user.followers', ['username' => $user->username]) }}">
                    <p class="text-gray-400"><span id="followers-count" class="text-black font-semibold">{{ count($user->followers) }}</span> <span id="followers-label">follower{{ count($user->followers) > 1 ? 's' : '' }}</span></p>
                </a>
            </div>
            <p>{{ $user["description"] }}</p>
            <p class="text-sm text-gray-400">Joined {{ $user->created_at->format('j F Y') }}
            </p>
            <div class="flex overflow-x-auto no-scrollbar gap-4 mt-2">
                <a class="flex-shrink-0" href="/users/{{ $user->username }}">
                    <div class="flex flex-col">
                        <p class="{{ getSubPage() == '' ? 'font-semibold' : 'text-gray-500' }} ' text-xs sm:text-md lg:text-base hover:text-gray-700' }}"">Overview</p>
                        @if(getSubPage() == '')
                            <div class="h-px bg-blue-500"></div>
                        @endif
                    </div>
                </a>
                <a class="flex-shrink-0" href="/users/{{ $user->username }}/posts">
                    <div class="flex flex-col">
                        <p class="{{ getSubPage() == 'posts' ? 'font-semibold' : 'text-gray-500' }} ' text-xs sm:text-md lg:text-base hover:text-gray-700' }}"">Posts</p>
                        @if(getSubPage() == 'posts')
                            <div class="h-px bg-blue-500"></div>
                        @endif
                    </div>
                </a>
                <a class="flex-shrink-0" href="/users/{{ $user->username }}/comments">
                    <div class="flex flex-col">
                        <p class="{{ getSubPage() == 'comments' ? 'font-semibold' : 'text-gray-500' }} ' text-xs sm:text-md lg:text-base hover:text-gray-700' }}"">Comments</p>
                        @if(getSubPage() == 'comments')
                            <div class="h-px bg-blue-500"></div>
                        @endif
                    </div>
                </a>
                @auth
                    @if ($user->id == Auth::id())
                        <a class="flex-shrink-0" href="/users/{{ $user->username }}/likes">
                            <div class="flex flex-col">
                                <p class="{{ getSubPage() == 'likes' ? 'font-semibold' : 'text-gray-500' }} ' text-xs sm:text-md lg:text-base hover:text-gray-700' }}"">Likes</p>
                                @if(getSubPage() == 'likes')
                                    <div class="h-px bg-blue-500"></div>
                                @endif
                            </div>
                        </a>
                        <a class="flex-shrink-0" href="/users/{{ $user->username }}/bookmarks">
                            <div class="flex flex-col">
                                <p class="{{ getSubPage() == 'bookmarks' ? 'font-semibold' : 'text-gray-500' }} ' text-xs sm:text-md lg:text-base hover:text-gray-700' }}"">Bookmarks</p>
                                @if(getSubPage() == 'bookmarks')
                                <div class="h-px bg-blue-500"></div>
                                @endif
                            </div>
                        </a>
                    @endif
                @endauth
            </div>
            {{ $slot }}
        </div>
        <x-trending />
    </div>

    <script>
        function toggleFollowButton() {
            const followButton = document.querySelector('#follow');
            const unfollowButton = document.querySelector('#unfollow');
            followButton.classList.toggle('hidden');
            unfollowButton.classList.toggle('hidden');
        }

        function addFollowCount(count) {
            const followersCount = document.querySelector('#followers-count');
            followersCount.innerText = String(Number(followersCount.innerText) + count);

            const label = document.querySelector('#followers-label');
            if (Number(followersCount.innerText) > 1) {
                label.innerText = 'followers';
            } else {
                label.innerText = 'follower';
            }
        }

        async function follow(userId, username) {
            await helper_follow(userId, username, '{{ $user->username }}');
            toggleFollowButton();
            addFollowCount(1);
        }

        async function unfollow(userId, username) {
            await helper_unfollow(userId, username, '{{ $user->username }}');
            toggleFollowButton();
            addFollowCount(-1);
        }
    </script>
</x-layout>