<div class="hidden md:block sticky h-full top-10 pt-2 pl-8 w-48">
    <ul class="flex flex-col">
        <li><a href="/" class="relative group flex gap-2 text-sm py-2 hover:bg-gray-200 transition transform rounded-lg px-4">
            <x-heroicon-o-home class="w-6 h-6 group-hover:hidden" />
            <x-heroicon-s-home class="w-6 h-6 hidden group-hover:block" />
            Home
        </a></li>
        @auth
        <li><a href="/chat" class="relative group flex gap-2 text-sm py-2 hover:bg-gray-200 transition transform rounded-lg px-4">
            <x-heroicon-o-chat-bubble-left-ellipsis class="w-6 h-6 group-hover:hidden" />
            <x-heroicon-s-chat-bubble-left-ellipsis class="w-6 h-6 hidden group-hover:block" />
            Chat
        </a></li>
        <li><a href="/notifications" class="relative group flex gap-2 text-sm py-2 hover:bg-gray-200 transition transform rounded-lg px-4">
            <x-heroicon-o-bell class="w-6 h-6 group-hover:hidden" />
            <x-heroicon-s-bell class="w-6 h-6 hidden group-hover:block" />
            Notifications
        </a></li>
        @endauth
        <li><a href="/corners" class="relative group flex gap-2 text-sm py-2 hover:bg-gray-200 transition transform rounded-lg px-4">
            <x-heroicon-o-rectangle-group class="w-6 group-hover:hidden" />
            <x-heroicon-s-rectangle-group class="w-6 h-6 hidden group-hover:block" />
            Corners
        </a></li>
    </ul>
    @auth
    <div class="mt-4 bg-gray-300 h-px w-full"></div>
    <a href="/create-corner" class="relative group flex gap-2 text-nowrap text-sm py-2 hover:bg-gray-200 transition transform rounded-lg px-4">
        <x-heroicon-o-user-group class="w-6 h-6 group-hover:hidden" />
        <x-heroicon-s-user-group class="w-6 h-6 hidden group-hover:block" />
        Create Corner
    </a>
    @endauth
    <div class="bg-gray-300 h-px w-full"></div>
    <div class="flex flex-col mt-4">
        @foreach ($corners as $corner)
            <x-left-corners name="{{ $corner->name }}" imageUrl="{{ asset('storage/icons/' . $corner->icon_url) }}" href="{{ route('corners.show', ['handle' => $corner->handle]) }}" />
        @endforeach
    </div>
</div>