@props(['name', 'imageUrl', 'href'])

<a href="{{ $href }}">
    <div class="flex items-center gap-2 cursor-pointer text-md py-2 hover:bg-gray-200 transition transform rounded-lg px-4">
        <Image class="w-6 h-6 inline" src="/img/{{ $imageUrl }}" alt="{{ $imageUrl }}" />
        {{ $name }}
    </div>
</a>