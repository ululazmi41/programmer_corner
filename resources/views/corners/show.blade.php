@php
    function getSubPage() {
        $variables = explode('/', Request::path());
        array_shift($variables);
        return implode('/', $variables);
    }
@endphp

<x-layout>
    <div class="flex justify-between md:gap-8 pt-12 md:pt-16">
        <x-left />
        <div class="w-full md:w-3/5 mx-auto px-4 pt-2 lg:pt-0 sm:px-8 md:px-0 mb-8">
            <div>
                <div id="bannerPlaceholder" class="{{ $corner["banner_url"] != "" ? "hidden" : "" }} w-full h-16 sm:h-24 bg-gray-300 rounded-tl-lg rounded-t-lg"></div>
                <img src="{{ $corner["banner_url"] != "" ? asset("storage/banners/{$corner["banner_url"]}") : "" }}" id="imgBanner" alt="banner"
                    class="{{ $corner["banner_url"] != "" ? "" : "hidden" }} w-full h-16 sm:h-24 object-cover rounded-t-lg transition-all duration-300 ease-in-out" />
            </div>
            <div class="mt-6 mx-auto">
                <div class="flex flex-col gap-2 sm:gap-0 sm:flex-row justify-between items-start sm:items-center">
                    <div class="flex items-center gap-2">
                        <img
                            class="w-12 h-12 sm:w-16 sm:h-16 rounded-full"
                            src="{{ $corner["icon_url"] != "" ? asset("storage/icons/" . $corner["icon_url"]) : "/img/group.png" }}"
                            alt="{{ $corner["icon_url"] != "" ? $corner["icon_url"] : "group.png" }}">
                        <div>
                            <p class="font-semibold text-sm sm:text-base">{{ $corner["name"] }}</p>
                            <p class="text-xs sm:text-sm text-gray-500">{{ rand(1, 999) }}K members</p>
                        </div>
                    </div>
                    <div class="flex gap-2 items-center">
                        @if ($joined)
                            <a href="{{ getSubPage() . '/create-post' }}">
                                <button class="text-xs sm:text-sm h-max lg:text-base text-blue-500 hover:text-white border border-blue-500 hover:bg-blue-500 rounded-lg py-1 px-3 lg:px-4 ml-auto">
                                    Create Post
                                </button>
                            </a>
                        @endif
                        @if ($role == 'owner')
                            <button class="text-xs sm:text-sm h-max lg:text-base text-white bg-blue-500 hover:bg-blue-700 rounded-lg py-1 px-3 lg:px-4 ml-auto">
                                Owner
                            </button>
                        @else
                            @if ($role == 'member')
                                <a href="{{ getSubPage() . '/leave' }}" class="group">
                                    <button class="text-xs sm:text-sm h-max lg:text-base text-white bg-blue-500 hover:bg-blue-700 rounded-lg py-1 px-3 lg:px-4 ml-auto">
                                        Leave
                                    </button>
                                </a>
                            @else
                                <a href="{{ getSubPage() . '/join' }}">
                                    <button class="text-xs sm:text-sm h-max lg:text-base text-white bg-blue-500 hover:bg-blue-700 rounded-lg py-1 px-3 lg:px-4 ml-auto">
                                        Join
                                    </button>
                                </a>
                            @endif
                        @endif
                    </div>
                </div>
                <p class="text-gray-500 text-xs sm:text-base my-2 line-clamp-2">{{ $corner["description"] }}</p>
                @if ($role === 'owner')
                    <a href="{{ getSubPage() . '/settings' }}">
                        <button class="text-xs sm:text-sm h-max text-white bg-blue-500 hover:bg-blue-700 rounded-lg py-1 px-3">
                            Settings
                        </button>
                    </a>
                @endif
                <div class="mt-2 h-px bg-gray-200"></div>
                @if (count($posts) > 0)
                    @foreach ($posts as $post)
                        <x-card
                            :$role
                            :type="\App\Enums\ContentType::POST"
                            :id="$post->id"
                            :postId="$post->id"
                            :status="$post['status']"
                            author="{{ $post->user->username }}"
                            authorId="{{ $post->user->id }}"
                            :authorUsername="$post->user->username"
                            date="{{ $post->created_at->format('j F Y') }}"
                            imageUrl="{{ $post->user->image_url }}"
                            title="{{ $post->title }}"
                            description="{{ $post->content }}"
                            likes="{{ $post->likesCount }}"
                            views="{{ $post->viewsCount }}"
                            comments="{{ $post->commentsCount }}"
                            :liked="$post->liked"
                            :bookmark="$post->bookmarked" />
                    @endforeach
                @else
                    <div class="grid px-4 w-5/6 m-auto md:w-full mt-12 lg:mt-16">
                        <div class="grid m-auto text-center">
                            <x-heroicon-c-chat-bubble-bottom-center-text class="m-auto auto w-8 h-8 md:w-16 md:h-16" />
                            <h1 class="font-bold text-sm md:text-lg">There's no post created yet...</h1>
                            <p class="text-xs md:text-md">Hmm... maybe check again after some time</p>
                        </div>
                    </div>
                @endif
            </div>
        </div>
        <x-trending />
    </div>
</x-layout>
