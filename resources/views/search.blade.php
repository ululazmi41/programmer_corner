<x-layout>
    <div class="flex md:gap-8 pt-8 md:pt-16">
        <x-left />
        <div class="grid w-full md:w-3/5">
            <div class="flex flex-col">
                @if(empty($posts))
                    <div class="grid px-4 w-5/6 m-auto md:w-full">
                        <div class="grid m-auto text-center">
                            <Image class="m-auto auto w-8 h-8 md:w-16 md:h-16" src="/img/python.png" alt="python.png" />
                            <h1 class="font-bold text-sm md:text-lg">There's none around here...</h1>
                            <p class="text-xs md:text-md">Hmm... maybe check your spellings or try different word</p>
                        </div>
                    </div>
                @else
                    @foreach ($posts as $post)
                        <x-card
                        author="{{ $post['author'] }}"
                        date="{{ $post['date'] }}"
                        imageUrl="{{ $post['imageUrl'] }}"
                        title="{{ $post['title'] }}"
                        description="{{ $post['description'] }}"
                        likes="{{ $post['likes'] }}"
                        views="{{ $post['views'] }}"
                        comments="{{ $post['comments'] }}"
                        :liked="$post['liked']"
                        :bookmark="$post['bookmark']" />
                    @endforeach
                @endif
            </div>
        </div>
        <x-right />
    </div>
</x-layout>