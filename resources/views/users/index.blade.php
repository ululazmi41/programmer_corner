<x-user.layout :$user>
    @if(empty($posts))
        <div class="h-3/5 grid px-4 w-5/6 m-auto md:w-full">
            <div class="grid m-auto text-center">
                <x-heroicon-s-chat-bubble-bottom-center-text class="m-auto auto w-8 h-8 md:w-16 md:h-16 text-gray-400" />
                <h1 class="font-bold text-sm md:text-lg text-gray-500">There's none around here...</h1>
                <p class="text-sm md:text-md font-semibold text-gray-500">Hmm... maybe check your spellings or try different word</p>
            </div>
        </div>
    @else
        @foreach ($posts as $post)
            <x-card-static
                type="post"
                id="1"
                :status="$post['status']"
                corner="1"
                :author="$post['author']"
                :date="Date::now()->format('j F Y')"
                :imageUrl="$post['image_url']"
                :title="$post['title']"
                :description="$post['description']"
                :likes="$post['likes']"
                :views="rand(1,999)"
                :comments="$post['comments']"
                :liked="false"
                :bookmark="$post['bookmark']" />
        @endforeach
    @endif
</x-user.layout>