@props(['user'])

@php
    function getSubPage() {
        $variables = explode('/', Request::path());
        if (count($variables) > 2) {
            return $variables[2];
        }
        return '';
    }
@endphp

<x-layout>
    <div class="flex md:gap-4 pt-4 md:pt-16">
        <x-left />
        <div class="w-full md:w-3/5 py-8 px-4 md:p-0 md:pb-4">
            <image id="icon" class="w-16 h-16 rounded-full" src="{{ $user["image_url"] ? asset('storage/icons/' . $user["image_url"]) : "/img/user.png" }}" alt="profile picture" />
            <p class="font-bold text-xl leading-tight">{{ $user["name"] }}</p>
            <p class="text-gray-400 leading-tight">{{ '@' }}{{ $user["username"] }}</p>
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
</x-layout>