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
                <div class="flex gap-2 p-2 items-center bg-gray-200 transition cursor-pointer">
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
            <div class="flex gap-2 p-2 items-center hover:bg-gray-100 transition cursor-pointer">
                <Image class="w-8 h-8 inline" src="/img/{{ 'javascript.png' }}" alt="{{ 'javascript.png' }}" />
                <div>
                    <p class="leading-tight text-sm font-bold">Javascript</p>
                    <p class="leading-tight text-sm">1 member</p>
                </div>
            </div>
            <div class="flex-1 overflow-y-auto space-y-2 no-scrollbar pt-4 pb-2">
                <div class="flex gap-2">
                    <Image class="w-8 h-8 inline rounded-full" src="/img/{{ 'javascript.png' }}" alt="{{ 'javascript.png' }}" />
                    <div>
                        <p class="text-sm font-bold leading-tight">Javascript</p>
                        <div class="text-sm bg-gray-200 mt-1 py-1 px-2 rounded-lg w-max h-max border border-black/20">
                            Welcome everyone, This will be our official group on this forums.
                        </div>
                    </div>
                </div>
                <div class="flex justify-end">
                    <div class="bg-green-200 py-1 px-2 rounded-lg w-max border border-black/20 grid">
                        Hey! Looks good so far. Excited to be part of this!
                    </div>
                </div>
                <div class="flex gap-2">
                    <Image class="w-8 h-8 inline rounded-full" src="/img/{{ 'user.png' }}" alt="{{ 'user.png' }}" />
                    <div>
                        <p class="text-sm"><span class="font-bold leading-tight">Lucy</span> (admin)</p>
                        <div class="text-sm bg-gray-200 mt-1 py-1 px-2 rounded-lg w-max h-max border border-black/20">
                            Welcome! 😄
                        </div>
                    </div>
                </div>
                <div class="flex gap-2">
                    <Image class="w-8 h-8 inline rounded-full" src="/img/{{ 'user.png' }}" alt="{{ 'user.png' }}" />
                    <div>
                        <p class="text-sm"><span class="font-bold leading-tight">Sarah</span></p>
                        <div class="text-sm bg-gray-200 mt-1 py-1 px-2 rounded-lg w-max h-max border border-black/20">
                            Same here! What's the main focus of this group again? 🤔
                        </div>
                    </div>
                </div>
                <div class="flex gap-2">
                    <Image class="w-8 h-8 inline rounded-full" src="/img/{{ 'user.png' }}" alt="{{ 'user.png' }}" />
                    <div class="max-w-[50%]">
                        <p class="text-sm"><span class="font-bold leading-tight">Lucy</span> (admin)</p>
                        <div class="text-sm bg-gray-200 mt-1 py-1 px-2 rounded-lg h-max border border-black/20">
                            Great question, Sarah! This group is for discussing all things related to the forum—updates, feedback, and community events. We'll also be sharing tips and answering any questions you might have. 😊
                        </div>
                    </div>
                </div>
                <div class="flex gap-2">
                    <Image class="w-8 h-8 inline rounded-full" src="/img/{{ 'user.png' }}" alt="{{ 'user.png' }}" />
                    <div class="max-w-[50%]">
                        <p class="text-sm font-bold leading-tight">Mike</p>
                        <div class="text-sm bg-gray-200 mt-1 py-1 px-2 rounded-lg h-max border border-black/20">
                            Sounds awesome! Can't wait to see what everyone shares here. 👍
                        </div>
                    </div>
                </div>
                <div class="flex justify-end">
                    <div class="bg-green-200 max-w-[50%] py-1 px-2 rounded-lg w-max border border-black/20 grid">
                        Nice, I'm curious about the upcoming forum features. Do we have a timeline for that?
                    </div>
                </div>
                <div class="flex gap-2">
                    <Image class="w-8 h-8 inline rounded-full" src="/img/{{ 'user.png' }}" alt="{{ 'user.png' }}" />
                    <div class="max-w-[50%]">
                        <p class="text-sm"><span class="font-bold leading-tight">Lucy</span> (admin)</p>
                        <div class="text-sm bg-gray-200 mt-1 py-1 px-2 rounded-lg h-max border border-black/20">
                            We're working on it! We should have more info by next week. Stay tuned! 📅
                        </div>
                    </div>
                </div>
                <div class="flex gap-2">
                    <Image class="w-8 h-8 inline rounded-full" src="/img/{{ 'user.png' }}" alt="{{ 'user.png' }}" />
                    <div class="max-w-[50%]">
                        <p class="text-sm font-bold leading-tight">John</p>
                        <div class="text-sm bg-gray-200 mt-1 py-1 px-2 rounded-lg h-max border border-black/20">
                            Will we be able to request new features or improvements here too? Like a "suggestions box"? 🤔
                        </div>
                    </div>
                </div>
                <div class="flex gap-2">
                    <Image class="w-8 h-8 inline rounded-full" src="/img/{{ 'user.png' }}" alt="{{ 'user.png' }}" />
                    <div class="max-w-[50%]">
                        <p class="text-sm"><span class="font-bold leading-tight">Lucy</span> (admin)</p>
                        <div class="text-sm bg-gray-200 mt-1 py-1 px-2 rounded-lg h-max border border-black/20">
                            Absolutely! Feel free to drop your suggestions anytime. We’ll take them into account.
                        </div>
                    </div>
                </div>
                <div class="flex justify-end">
                    <div class="bg-green-200 max-w-[50%] py-1 px-2 rounded-lg w-max border border-black/20 grid">
                        Love that! By the way, do we have a group code of conduct, or should we just keep things friendly and respectful? 😅
                    </div>
                </div>
                <div class="flex gap-2">
                    <Image class="w-8 h-8 inline rounded-full" src="/img/{{ 'user.png' }}" alt="{{ 'user.png' }}" />
                    <div class="max-w-[50%]">
                        <p class="text-sm"><span class="font-bold leading-tight">Lucy</span> (admin)</p>
                        <div class="text-sm bg-gray-200 mt-1 py-1 px-2 rounded-lg h-max border border-black/20">
                            Good point, Sarah! Let's keep things respectful and friendly. We want everyone to feel welcome here! I'll post some guidelines in a pinned message later. 😊
                        </div>
                    </div>
                </div>
                <div class="flex gap-2">
                    <Image class="w-8 h-8 inline rounded-full" src="/img/{{ 'user.png' }}" alt="{{ 'user.png' }}" />
                    <div class="max-w-[50%]">
                        <p class="text-sm font-bold leading-tight">Mike</p>
                        <div class="text-sm bg-gray-200 mt-1 py-1 px-2 rounded-lg h-max border border-black/20">
                            Perfect! Just making sure, we'll also be able to share media like images and videos, right? 📸
                        </div>
                    </div>
                </div>
                <div class="flex gap-2">
                    <Image class="w-8 h-8 inline rounded-full" src="/img/{{ 'user.png' }}" alt="{{ 'user.png' }}" />
                    <div class="max-w-[50%]">
                        <p class="text-sm"><span class="font-bold leading-tight">Lucy</span> (admin)</p>
                        <div class="text-sm bg-gray-200 mt-1 py-1 px-2 rounded-lg h-max border border-black/20">
                            Yes! You'll be able to share images, videos, and links once the settings are finalized. More details coming soon!
                        </div>
                    </div>
                </div>
                <div class="flex justify-end">
                    <div class="bg-green-200 max-w-[50%] py-1 px-2 rounded-lg w-max border border-black/20 grid">
                        Awesome! Can't wait to dive into the discussions. 😎
                    </div>
                </div>
                <div class="flex gap-2">
                    <Image class="w-8 h-8 inline rounded-full" src="/img/{{ 'user.png' }}" alt="{{ 'user.png' }}" />
                    <div class="max-w-[50%]">
                        <p class="text-sm"><span class="font-bold leading-tight">Lucy</span> (admin)</p>
                        <div class="text-sm bg-gray-200 mt-1 py-1 px-2 rounded-lg h-max border border-black/20">
                            Thanks for the enthusiasm, everyone! Let's keep the energy going. Feel free to introduce yourselves and tell us what you're most excited about in the forum!
                        </div>
                    </div>
                </div>
                <div class="flex gap-2">
                    <Image class="w-8 h-8 inline rounded-full" src="/img/{{ 'user.png' }}" alt="{{ 'user.png' }}" />
                    <div class="max-w-[50%]">
                        <p class="text-sm font-bold leading-tight">Emily</p>
                        <div class="text-sm bg-gray-200 mt-1 py-1 px-2 rounded-lg h-max border border-black/20">
                            Sure! I'm Emily, and I'm here for all the behind-the-scenes updates! Always love getting the inside scoop! 👀
                        </div>
                    </div>
                </div>
                <div class="flex gap-2">
                    <Image class="w-8 h-8 inline rounded-full" src="/img/{{ 'user.png' }}" alt="{{ 'user.png' }}" />
                    <div class="max-w-[50%]">
                        <p class="text-sm font-bold leading-tight">Sarah</p>
                        <div class="text-sm bg-gray-200 mt-1 py-1 px-2 rounded-lg h-max border border-black/20">
                            I'm Sarah! I'll be here for any community-building discussions and ideas. Always up for some fun conversations! 💬
                        </div>
                    </div>
                </div>
                <div class="flex gap-2">
                    <Image class="w-8 h-8 inline rounded-full" src="/img/{{ 'user.png' }}" alt="{{ 'user.png' }}" />
                    <div class="max-w-[50%]">
                        <p class="text-sm font-bold leading-tight">John</p>
                        <div class="text-sm bg-gray-200 mt-1 py-1 px-2 rounded-lg h-max border border-black/20">
                            John here! I'm into gaming and memes. So yeah, expect some fun posts from me! 😂
                        </div>
                    </div>
                </div>
                <div class="flex gap-2">
                    <Image class="w-8 h-8 inline rounded-full" src="/img/{{ 'user.png' }}" alt="{{ 'user.png' }}" />
                    <div class="max-w-[50%]">
                        <p class="text-sm"><span class="font-bold leading-tight">Lucy</span> (admin)</p>
                        <div class="text-sm bg-gray-200 mt-1 py-1 px-2 rounded-lg h-max border border-black/20">
                            Love all these introductions! Let's keep the conversation going. Don't forget to check out the pinned posts for updates. More soon! 😊
                        </div>
                    </div>
                </div>
            </div>

            <input
                type="text"
                class="flex w-full px-4 py-1 bg-gray-200 border border-lg border-gray-400 min-h-8" />

            {{-- <div class="px-4 py-2 rounded-xl bg-green-300 h-max w-max m-auto">Join chat</div> --}}

            {{-- <div class="col-span-4 p-4 m-auto">
                <div>
                    <x-heroicon-c-chat-bubble-left-right class="w-48 h-48 text-blue-400" />
                    <p class="font-bold">Welcome to chat!</p>
                    <p>Select corner or people to chat</p>
                </div>
            </div> --}}
        </div>
    </div>
</body>
</html>