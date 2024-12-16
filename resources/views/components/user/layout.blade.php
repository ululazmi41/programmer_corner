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
        <div class="w-full py-8 px-4 md:p-0">
            <image id="icon" class="w-16 h-16 rounded-full" src="{{ $user["image_url"] ? asset('storage/icons/' . $user["image_url"]) : "/img/user.png" }}" alt="profile picture" />
            <p class="font-bold text-xl leading-tight">{{ $user["name"] }}</p>
            <p class="text-gray-400 leading-tight">{{ '@' }}{{ $user["username"] }}</p>
            <p>TODO: User Description.</p>
            <p class="text-sm text-gray-400">Joined {{ $user->created_at->format('j F Y') }}
            </p>
            <div class="flex gap-4 mt-2">
                <a href="/users/{{ $user->username }}">
                    <div class="flex flex-col">
                        <p class="{{ getSubPage() == '' ? 'font-semibold' : 'text-gray-500 hover:text-gray-700' }}">Overview</p>
                        @if(getSubPage() == '')
                            <div class="h-px bg-blue-500"></div>
                        @endif
                    </div>
                </a>
                <a href="/users/{{ $user->username }}/posts">
                    <div class="flex flex-col">
                        <p class="{{ getSubPage() == 'posts' ? 'font-semibold' : 'text-gray-500 hover:text-gray-700' }}">Posts</p>
                        @if(getSubPage() == 'posts')
                            <div class="h-px bg-blue-500"></div>
                        @endif
                    </div>
                </a>
                <a href="/users/{{ $user->username }}/comments">
                    <div class="flex flex-col">
                        <p class="{{ getSubPage() == 'comments' ? 'font-semibold' : 'text-gray-500 hover:text-gray-700' }}">Comments</p>
                        @if(getSubPage() == 'comments')
                            <div class="h-px bg-blue-500"></div>
                        @endif
                    </div>
                </a>
            </div>
            {{ $slot }}
        </div>
        <x-right />
    </div>
</x-layout>