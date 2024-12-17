<x-layout>
    <div class="flex md:gap-8 pt-8 md:pt-16">
        <x-left />
        <div class="lg:w-3/5 sm:pr-2 lg:pr-0">
            @if(empty($posts))
                <div class="h-3/5 grid px-4 w-5/6 m-auto md:w-full">
                    <div class="grid m-auto text-center">
                        <x-heroicon-s-chat-bubble-bottom-center-text class="m-auto auto w-8 h-8 md:w-16 md:h-16 text-gray-400" />
                        <h1 class="font-bold text-sm md:text-lg text-gray-500">There's none around here...</h1>
                        <p class="text-sm md:text-md font-semibold text-gray-500">Hmm... maybe check again for later...</p>
                    </div>
                </div>
            @else
                <div class="flex flex-col bg-blue-500">
                    @foreach ($posts as $post)
                        <x-card
                        :status="$post['status']"
                        author="{{ $post['author'] }}"
                        date="{{ $post['date'] }}"
                        imageUrl="{{ $post['image_url'] }}"
                        title="{{ $post['title'] }}"
                        description="{{ $post['description'] }}"
                        likes="{{ $post['likes'] }}"
                        views="{{ $post['views'] }}"
                        comments="{{ $post['comments'] }}"
                        :liked="$post['liked']"
                        :bookmark="$post['bookmark']" />
                    @endforeach
                </div>
            @endif
        </div>
        <x-right />
    </div>
</x-layout>