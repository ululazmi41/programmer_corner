<x-layout>
    <div class="flex md:gap-8 pt-8 md:pt-16">
        <x-left />
        <div class="grid w-full md:w-3/5">
            <div class="flex flex-col">
                <form class="sm:hidden w-full mt-4 px-8" action="{{ route('search') }}" method="GET">
                    <input
                        class="w-full text-gray-700 shadow appearance-none border rounded py-2 px-3 leading-tight focus:outline-none focus:shadow-outline"
                        name="query" id="query" type="text" placeholder="Search" />
                </form>
                @if(count($posts) == 0)
                    <div class="grid px-4 w-5/6 m-auto md:w-full mt-24 lg:mt-32">
                        <div class="grid m-auto text-center">
                            <x-heroicon-o-magnifying-glass class="m-auto auto w-8 h-8 md:w-12 md:h-12" />
                            <h1 class="font-bold text-sm md:text-lg">There's no post found...</h1>
                            <p class="text-xs md:text-md">Hmm... maybe check your spellings or try different word</p>
                        </div>
                    </div>
                @else
                    @foreach ($posts as $post)
                        <x-card
                            role="guest"
                            :type="\App\Enums\ContentType::POST"
                            :id="$post->id"
                            :postId="$post->id"
                            :status="$post['status']"
                            :corner="$post->corner->handle"
                            author="{{ $post->user->username }}"
                            authorId="{{ $post->user->id }}"
                            authorUsername="{{ $post->user->username }}"
                            date="{{ $post->created_at->format('j F Y') }}"
                            imageUrl="{{ $post->user->image_url }}"
                            :title="$post->title"
                            :description="$post->content"
                            :likes="$post->likesCount"
                            :views="$post->viewsCount"
                            :comments="$post->commentsCount"
                            :liked="$post->liked"
                            :bookmark="$post->bookmarked" />
                    @endforeach
                @endif
            </div>
        </div>
        <x-trending />
    </div>
</x-layout>