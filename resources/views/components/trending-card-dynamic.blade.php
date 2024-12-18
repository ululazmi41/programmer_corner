<a
    href="{{ route("posts.show", ["id" => $id]) }}"
    class="flex gap-2 px-2 py-1 items-center text-gray-500 hover:bg-gray-100 transition">
    <Image
        class="w-8 h-8 inline"
        src="{{ $imageUrl != "" ? asset("storage/icons/" . $imageUrl) : "/img/group.png" }}"
        alt="{{ $imageUrl != "" ? $imageUrl : "group.png" }}" />
    <div>
        <p class="leading-tight text-sm font-bold">{{ $title }}</p>
        <p class="leading-tight text-sm line-clamp-1">{{ $description }}</p>
        <p class="leading-tight text-xs">{{ $likes }} likes ⸱ {{ $comments }} comments</p>
    </div>
</a>