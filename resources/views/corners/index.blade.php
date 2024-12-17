<x-layout>
    <div class="flex justify-between md:gap-8 pt-12 md:pt-16">
        <x-left />
        <div class="w-3/4 lg:w-6/12 mx-auto py-4">
            <h1 class="font-bold text-lg text-gray-500">Corners</h1>
            <div class="h-2"></div>
            @if (count($corners) > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 auto-rows-max justify-center">
                    @foreach ($corners as $corner)
                        <a href="/corners/{{ $corner["handle"] }}" class="hover:bg-gray-200 px-4 py-2 rounded-md">
                            <div class="flex items-center gap-4">
                                <img
                                    class="w-12 h-12 rounded-full"
                                    src="{{ $corner["icon_url"] != "" ? asset("storage/icons/" . $corner["icon_url"]) : "/img/group.png" }}"
                                    alt="{{ $corner["icon_url"] != "" ? $corner["icon_url"] : "group.png" }}">
                                <div>
                                    <h2 class="text-sm font-semibold">{{ $corner["name"] }}</h2>
                                    <p class="text-xs text-gray-500">{{ rand(1, 999) }}K members</p>
                                </div>
                            </div>
                            <p class="text-sm line-clamp-2 text-gray-500">{{ $corner["description"] }}</p>
                        </a>
                    @endforeach
                </div>
            @else
                <div class="grid px-4 w-5/6 m-auto md:w-full">
                    <div class="grid m-auto text-center">
                        <Image class="m-auto auto w-8 h-8 md:w-16 md:h-16" src="/img/group.png" alt="group.png" />
                        <h1 class="font-bold text-sm md:text-lg">There's no corner created yet...</h1>
                        <p class="text-xs md:text-md">Hmm... maybe check again after some time</p>
                    </div>
                </div>
            @endif
        </div>
        <x-right />
    </div>
</x-layout>
