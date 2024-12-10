<div class="flex gap-2 px-2 py-1 items-center text-gray-500 hover:bg-gray-100 transition cursor-pointer">
    <Image class="w-8 h-8 inline" src="/img/{{ $imageUrl }}" alt="{{ $imageUrl }}" />
    <div>
        <p class="leading-tight text-sm font-bold">{{ $title }}</p>
        <p class="leading-tight text-sm line-clamp-1">{{ $description }}</p>
        <p class="leading-tight text-xs">{{ $likes }} likes ⸱ {{ $comments }} comments</p>
    </div>
</div>