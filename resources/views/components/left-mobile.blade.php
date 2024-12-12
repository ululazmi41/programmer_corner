<div class="p-2 sm:p-4 max-w-48 bg-white">
    <ul class="flex flex-col">
        <li><a href="/" class="w-max flex gap-2 text-sm sm:text-md py-2 hover:bg-gray-200 transition transform rounded-lg px-4">
            <x-heroicon-o-home class="w-6 h-6 sm:w-6 sm:h-6 inline" />
            Home
        </a></li>
        <li><a href="/chat" class="flex gap-2 text-sm sm:text-md py-2 hover:bg-gray-200 transition transform rounded-lg px-4">
            <x-heroicon-o-chat-bubble-left-ellipsis class="w-6 h-6 sm:w-6 sm:h-6 inline" />
            Chat
        </a></li>
        <li><a href="/notifications" class="flex gap-2 text-sm sm:text-md py-2 hover:bg-gray-200 transition transform rounded-lg px-4">
            <x-heroicon-o-bell class="w-6 h-6 sm:w-6 sm:h-6 inline" />
            Notifications
        </a></li>
        <li><a href="/corners" class="flex gap-2 text-sm sm:text-md py-2 hover:bg-gray-200 transition transform rounded-lg px-4">
            <x-heroicon-o-rectangle-group class="w-6 h-6 sm:w-6 sm:h-6 inline" />
            Corners
        </a></li>
    </ul>
    <div class="mt-2 bg-gray-300 h-px w-full overflow-auto"></div>
    <div class="flex flex-col mt-2 gap-1">
        <x-left-corners name="Golang" imageUrl="go.png" href="/" />
        <x-left-corners name="Rust" imageUrl="rust.png" href="/" />
        <x-left-corners name="Ruby" imageUrl="ruby.png" href="/" />
        <x-left-corners name="Kotlin" imageUrl="kotlin.png" href="/" />
        <x-left-corners name="Typescript" imageUrl="typescript.png" href="/" />
        <x-left-corners name="Python" imageUrl="python.png" href="/" />
        <x-left-corners name="Javascript" imageUrl="javascript.png" href="/" />
        <x-left-corners name="Dart" imageUrl="dart.png" href="/" />
    </div>
</div>