<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Chat | PiCorner</title>
    @vite(['resources/js/app.js'])
</head>
<body>
    <div class="h-screen flex">
        <div class="w-1/5 px-4 py-2">
            <h2 class="py-4 text-xl font-semibold">Chat</h2>
            <div class="">
                <div class="flex gap-2 p-2 items-center hover:bg-gray-100 transition cursor-pointer">
                    <Image class="w-10 h-10 inline" src="/img/{{ 'javascript.png' }}" alt="{{ 'javascript.png' }}" />
                    <div>
                        <p class="leading-tight text-sm font-bold">Javascript</p>
                        <p class="leading-tight text-sm">Ronald: Yes, that's correct...</p>
                    </div>
                </div>
                <div class="flex gap-2 p-2 items-center hover:bg-gray-100 transition cursor-pointer">
                    <Image class="w-10 h-10 inline" src="/img/{{ 'go.png' }}" alt="{{ 'go.png' }}" />
                    <div>
                        <p class="leading-tight text-sm font-bold">Golang</p>
                        <p class="leading-tight text-sm">Civ: About that message...</p>
                    </div>
                </div>
                <div class="flex gap-2 p-2 items-center hover:bg-gray-100 transition cursor-pointer">
                    <Image class="w-10 h-10 inline" src="/img/{{ 'rust.png' }}" alt="{{ 'rust.png' }}" />
                    <div>
                        <p class="leading-tight text-sm font-bold">Rust</p>
                        <p class="leading-tight text-sm">Nacy: Nope, still no clue at...</p>
                    </div>
                </div>
                <div class="flex gap-2 p-2 items-center hover:bg-gray-100 transition cursor-pointer">
                    <Image class="w-10 h-10 inline" src="/img/{{ 'kotlin.png' }}" alt="{{ 'kotlin.png' }}" />
                    <div>
                        <p class="leading-tight text-sm font-bold">Kotlin</p>
                        <p class="leading-tight text-sm">Daniel: Sorry, but I've...</p>
                    </div>
                </div>
                <div class="flex gap-2 p-2 items-center hover:bg-gray-100 transition cursor-pointer">
                    <Image class="w-10 h-10 inline" src="/img/{{ 'typescript.png' }}" alt="{{ 'typescript.png' }}" />
                    <div>
                        <p class="leading-tight text-sm font-bold">Typescript</p>
                        <p class="leading-tight text-sm">Bob: That's not supposed...</p>
                    </div>
                </div>
                <div class="flex gap-2 p-2 items-center hover:bg-gray-100 transition cursor-pointer">
                    <Image class="w-10 h-10 inline" src="/img/{{ 'ruby.png' }}" alt="{{ 'ruby.png' }}" />
                    <div>
                        <p class="leading-tight text-sm font-bold">Ruby</p>
                        <p class="leading-tight text-sm">Lily: Just rest the case, and...</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="w-4/5 px-4 pt-2 pb-4 flex flex-col">
            {{-- <div class="flex gap-2 p-2 items-center hover:bg-gray-100 transition cursor-pointer">
                <Image class="w-8 h-8 inline" src="/img/{{ 'javascript.png' }}" alt="{{ 'javascript.png' }}" />
                <div>
                    <p class="leading-tight text-sm font-bold">Javascript</p>
                    <p class="leading-tight text-sm">1 member</p>
                </div>
            </div>
            <div class="flex-1 overflow-y-auto no-scrollbar pt-4">
                <div class="bg-gray-200 py-1 px-2 rounded-lg w-max h-max border border-black/20">
                    bubble left
                </div>
                <div class="flex justify-end">
                    <div class="bg-green-200 py-1 px-2 rounded-lg w-max border border-black/20 grid">
                        bubble right
                    </div>
                </div>
            </div>

            <input
                type="text"
                class="flex w-full px-4 py-1 bg-gray-200 border border-lg border-gray-400 min-h-8" /> --}}

            {{-- <div class="px-4 py-2 rounded-xl bg-green-300 h-max w-max m-auto">Join chat</div> --}}

            <div class="col-span-4 p-4 m-auto">
                <div>
                    <x-heroicon-c-chat-bubble-left-right class="w-48 h-48 text-blue-400" />
                    <p class="font-bold">Welcome to chat!</p>
                    <p>Select corner or people to chat</p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>