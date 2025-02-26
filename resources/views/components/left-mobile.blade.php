<div class="p-2 sm:p-4 max-w-48 bg-white">
    <ul class="flex flex-col">
        <li><a href="/" class="w-max flex gap-2 text-sm sm:text-md py-2 hover:bg-gray-200 transition transform rounded-lg px-4">
            <x-heroicon-o-home class="w-6 h-6 sm:w-6 sm:h-6 inline" />
            Home
        </a></li>
        @auth
        <li><a href="/chat" class="flex gap-2 text-sm sm:text-md py-2 hover:bg-gray-200 transition transform rounded-lg px-4">
            <x-heroicon-o-chat-bubble-left-ellipsis class="w-6 h-6 sm:w-6 sm:h-6 inline" />
            Chat
        </a></li>
        <li><a href="/notifications" class="flex gap-2 text-sm sm:text-md py-2 hover:bg-gray-200 transition transform rounded-lg px-4">
            <x-heroicon-o-bell class="w-6 h-6 sm:w-6 sm:h-6 inline" />
            Notifications
        </a></li>
        @endauth
        <li><a href="/corners" class="flex gap-2 text-sm sm:text-md py-2 hover:bg-gray-200 transition transform rounded-lg px-4">
            <x-heroicon-o-rectangle-group class="w-6 h-6 sm:w-6 sm:h-6 inline" />
            Corners
        </a></li>
    </ul>
    @auth
    <div class="mt-2 bg-gray-300 h-px w-full overflow-auto"></div>
    <a href="/create-corner" class="relative group flex gap-2 text-nowrap text-sm py-2 hover:bg-gray-200 transition transform rounded-lg px-4">
        <x-heroicon-o-user-group class="w-6 h-6 group-hover:hidden" />
        <x-heroicon-s-user-group class="w-6 h-6 hidden group-hover:block" />
        Create Corner
    </a>
    @endauth
    <div class="bg-gray-300 h-px w-full overflow-auto"></div>
    <div class="flex flex-col mt-2 gap-1">
        @foreach ($corners as $corner)
            <x-left-corners name="{{ $corner->name }}" imageUrl="{{ asset('storage/icons/' . $corner->icon_url) }}" href="{{ route('corners.show', ['handle' => $corner->handle]) }}" />
        @endforeach
    </div>
</div>