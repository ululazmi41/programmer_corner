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
    <div class="flex md:gap-8 pt-8 md:pt-16">
        <x-left />
        <div class="w-full md:w-3/5">
            <x-heroicon-o-user-circle class="w-16 h-1w-16 text-gray-400 cursor-pointer" />
            <p class="font-bold text-xl leading-tight">Ulul Azmi</p>
            <p class="text-gray-400 leading-tight">@ululazmi</p>
            <p>Learner.</p>
            <p class="text-sm text-gray-400">Joined 5 December 2024</p>
            <div class="flex gap-4 mt-2">
                <a href="/users/{{ $user->handle }}">
                    <div class="flex flex-col">
                        <p class="{{ getSubPage() == '' ? 'font-semibold' : 'text-gray-500 hover:text-gray-700' }}">Overview</p>
                        @if(getSubPage() == '')
                            <div class="h-px bg-blue-500"></div>
                        @endif
                    </div>
                </a>
                <a href="/users/{{ $user->handle }}/posts">
                    <div class="flex flex-col">
                        <p class="{{ getSubPage() == 'posts' ? 'font-semibold' : 'text-gray-500 hover:text-gray-700' }}">Posts</p>
                        @if(getSubPage() == 'posts')
                            <div class="h-px bg-blue-500"></div>
                        @endif
                    </div>
                </a>
                <a href="/users/{{ $user->handle }}/comments">
                    <div class="flex flex-col">
                        <p class="{{ getSubPage() == 'comments' ? 'font-semibold' : 'text-gray-500 hover:text-gray-700' }}">Comments</p>
                        @if(getSubPage() == 'comments')
                            <div class="h-px bg-blue-500"></div>
                        @endif
                    </div>
                </a>
            </div>
            <div>
                {{ $user->handle }}
                {{ $slot }}
            </div>
        </div>
        <x-right />
    </div>
</x-layout>