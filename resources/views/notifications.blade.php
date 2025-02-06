<x-layout>
    <div class="flex md:gap-8 pt-8 md:pt-16">
        <x-left />
        <div class="grid m-auto sm:w-4/5 md:w-3/5 md:mt-4">
            <div class="mx-auto p-6 md:p-0">
                <h1 class="text-lg text-gray-700 font-bold">Notifications</h1>
                @foreach ($notifications as $notification)
                    <div class="hover:bg-gray-200 py-4 px-4 md:p-4 grid grid-cols-[max-content_1fr] gap-x-2 md:gap-x-4">
                        <div>
                            @if ($notification['type'] == \App\Enums\NotificationType::LIKE)
                                <x-heroicon-s-heart class="w-6 h-6 md:w-8 md:h-8 text-red-500" />
                            @elseif ($notification['type'] == \App\Enums\NotificationType::COMMENT)
                                <x-heroicon-s-chat-bubble-left-right class="w-6 h-6 md:w-8 md:h-8 text-blue-500" />
                            @elseif ($notification['type'] == \App\Enums\NotificationType::FOLLOW)
                                <x-heroicon-s-user-plus class="w-6 h-6 md:w-8 md:h-8 text-blue-500" />
                            @elseif ($notification['type'] == \App\Enums\NotificationType::PROMOTEADMIN)
                                <x-heroicon-s-user-plus class="w-6 h-6 md:w-8 md:h-8 text-blue-500" />
                            @endif
                        </div>
                        <div>
                            <div class="flex gap-2">
                                @foreach ($notification['users'] as $user)
                                @if ($notification['type'] !== \App\Enums\NotificationType::FOLLOW)
                                    <a href="/users/{{ $user['username'] }}" class="inline-block text-blue-500 hover:underline">
                                        <img class="my-auto w-6 h-6 sm:w-8 sm:h-8" src="/img/{{ $user['image_url'] }}"
                                            alt="{{ $user['image_url'] }}">
                                    </a>
                                @else
                                    <a href="/users/{{ $user['username'] }}" class="inline-block text-blue-500 hover:underline">
                                        <img class="my-auto w-6 h-6 sm:w-8 sm:h-8 rounded-full" src="{{ $user["image_url"] ? asset('storage/icons/' . $user["image_url"]) : "/img/user.png" }}" alt="{{ $user['image_url'] }}">
                                    </a>
                                @endif
                                @endforeach
                            </div>
                            <p class="flex flex-wrap text-gray-500 text-xs md:text-sm leading-tight">
                                @foreach ($notification['users'] as $index => $user)
                                    @if (count($notification['users']) > 1 && $index == count($notification['users']) - 1)
                                        &nbsp;and&nbsp;
                                    @endif
                                    <a href="/users/{{ $user['username'] }}" class="inline-block text-blue-500 hover:underline font-semibold">
                                        {{ $user['username'] }}
                                    </a>
                                    @if ($index < count($notification['users']) - 2)
                                        ,&nbsp;
                                    @endif
                                @endforeach
                                @if ($notification['type'] === \App\Enums\NotificationType::LIKE)
                                    &nbsp;liked your post.
                                @elseif ($notification['type'] === \App\Enums\NotificationType::COMMENT)
                                    &nbsp;commented your post.
                                @elseif ($notification['type'] === \App\Enums\NotificationType::FOLLOW)
                                    &nbsp;followed you.
                                @elseif ($notification['type'] === \App\Enums\NotificationType::PROMOTEADMIN)
                                    &nbsp;you are promoted as admin.
                                @endif
                                </p>
                        </div>
                        <div></div>
                        <div>
                            @if ($notification['type'] !== \App\Enums\NotificationType::FOLLOW)
                                <a href="/posts/1">
                                    <p class="text-gray-500 text-xs sm:text-md font-bold leading-tight line-clamp-2">
                                        {!! $notification['title'] !!}
                                    </p>
                                </a>
                                <a href="/posts/1">
                                    <p class="text-gray-500 leading-tight text-xs md:text-sm line-clamp-3">
                                        {!! $notification['description'] !!}
                                    </p>
                                </a>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        <x-trending />
    </div>
</x-layout>
