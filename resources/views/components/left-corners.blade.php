@props(['name', 'imageUrl', 'href'])

<a href="{{ $href }}">
    <div class="flex items-center gap-2 cursor-pointer text-sm sm:text-md py-2 hover:bg-gray-200 transition transform rounded-lg px-4">
        <Image class="w-4 h-4 sm:w-6 sm:h-6 inline" src="{{ $imageUrl }}" alt="{{ $imageUrl }}" />
        {{ $name }}
    </div>
</a>