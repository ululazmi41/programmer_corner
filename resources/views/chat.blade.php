<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Chat | PiCorner</title>
    @vite(['resources/js/app.js'])
</head>
<body>
    <div class="h-screen flex">
        <div class="w-1/5 px-4 py-2 no-scrollbar max-h-screen overflow-y-auto">
            <h2 class="py-4 text-xl font-semibold">Chat</h2>
            <div id="chatrooms" class="grid gap-1">
                @foreach ($chatrooms as $room)
                    <x-chat.chatroom
                        :$room
                        onclick="select(
                            {{ $room['id'] }},
                            {{ Auth::id() }},
                            {{ $room['conversation_id'] }},
                            '{{ $room['type'] }}',
                            '{{ $room['name'] }}',
                            '{{ asset('storage/icons/' . $room['image_url']) }}',
                            '{{ $room['image_url'] }}',
                            '{{ $room['handle'] }}');" />
                @endforeach
                <div class="flex gap-2 p-2 items-center hover:bg-gray-200 transition cursor-pointer">
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
            <div class="flex justify-between">
                <div class="flex gap-2 p-2 items-center transition">
                    <a id="room-icon-wrapper" href="#">
                        <Image id="room-icon" class="w-8 h-8 inline" src="/img/{{ 'javascript.png' }}" alt="{{ 'javascript.png' }}" />
                    </a>
                    <a id="room-name-wrapper" href="#">
                        <p id="room-name" class="leading-tight text-sm font-bold">Javascript</p>
                    </a>
                </div>
                <button
                    id="leave"
                    class="hidden text-sm hover:text-red-400 px-2 py-1 rounded-md">
                    Leave
                </button>
            </div>

            <div
                id="introduction"
                class="col-span-4 p-4 m-auto">
                <div class="text-center">
                    <x-heroicon-c-chat-bubble-left-right class="w-48 h-48 text-blue-400" />
                    <p class="font-bold">Welcome to chat!</p>
                    <p>Select corner or people to chat</p>
                </div>
            </div>

            <div
                id="chat"
                class="hidden flex-1 overflow-y-auto space-y-2 no-scrollbar pt-4 pb-2">
                <div class="flex gap-2">
                    <Image class="w-8 h-8 inline rounded-full" src="/img/{{ 'javascript.png' }}" alt="{{ 'javascript.png' }}" />
                    <div>
                        <p class="text-sm font-bold leading-tight">Javascript</p>
                        <div class="text-sm bg-gray-200 mt-1 py-1 px-2 rounded-lg w-max h-max border border-black/20">
                            Welcome everyone, This will be our official group on this forums.
                        </div>
                    </div>
                </div>
                <div class="flex justify-center">
                    <div class="bg-gray-200 text-sm py-1 px-2 rounded-lg w-max border border-black/20 grid">
                        Ulul Azmi joined the group
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

            <form
                id="messageForm"
                method="POST">
                <input
                    type="text"
                    id="message"
                    class="hidden w-full px-4 py-1 bg-gray-200 border border-lg border-gray-400 min-h-8" />
            </form>

            <button
                id="message_join"
                onclick=""
                class="hidden px-3 py-1 rounded-lg text-md bg-blue-500 hover:bg-blue-700 transition all 0.2s text-white h-max w-max m-auto">
                Join chat
            </button>
        </div>
    </div>

    <script>
        window.onload = () => {
            const roomId = sessionStorage.getItem('roomId');
            const userId = sessionStorage.getItem('userId');
            const roomType = sessionStorage.getItem('roomType');
            const roomName = sessionStorage.getItem('roomName');
            const roomImageUrl = sessionStorage.getItem('roomImageUrl');
            const conversationId = sessionStorage.getItem('conversationId');
            const roomImageUrlAlt = sessionStorage.getItem('roomImageUrlAlt');
            const handle = sessionStorage.getItem('handle');

            select(roomId, userId, conversationId, roomType, roomName, roomImageUrl, roomImageUrlAlt, handle);
        }

        function isAtBottom() {
            const chat = document.querySelector('#chat');
            return chat.scrollHeight - chat.scrollTop === chat.clientHeight;
        }

        const form = document.querySelector('#messageForm');
        form.addEventListener('submit', (e) => {
            event.preventDefault();

            const message = document.querySelector('#message');
            const userId = sessionStorage.getItem('userId');
            const conversationId = sessionStorage.getItem('conversationId');

            const formData = new FormData();
            formData.append('content', message.value);
            formData.append('userId', userId);
            formData.append('conversationId', conversationId);

            fetch('/chat/send-message', {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: formData,
            })
            .then(response => response.json())
            .then(data => {
                const chat = document.querySelector('#chat');
                const messageElement = createMyMessage(message.value);

                const wasAtBottom = isAtBottom();

                chat.appendChild(messageElement);
                
                if (wasAtBottom) {
                    chat.scrollTop = chat.scrollHeight;
                }

                const roomId = sessionStorage.getItem('roomId');
                const lastMessage = document.querySelector(`#room-${roomId}-last-message`);
                lastMessage.innerText = `you: ${message.value}`;
            });
        });

        function join(userId, conversationId) {
            const formData = new FormData();
            formData.append('userId', userId);
            formData.append('conversationId', conversationId);

            fetch('/chat/join', {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: formData,
            })
            .then(response => response.json())
            .then(data => {
                sessionStorage.setItem('isMember', true);

                const leaveElement = document.querySelector('#leave');
                const message = document.querySelector('#message');
                const messageJoin = document.querySelector('#message_join');

                const userId = sessionStorage.getItem('userId');
                const conversationId = sessionStorage.getItem('conversationId');

                message.classList.remove('hidden');
                messageJoin.classList.add('hidden');
                leaveElement.classList.remove('hidden');

                leaveElement.onclick = () => leave(userId, conversationId);
            });
        }

        function select(roomId, userId, conversationId, roomType, roomName, roomImageUrl, roomImageUrlAlt, handle) {
            sessionStorage.setItem('roomId', roomId);
            sessionStorage.setItem('userId', userId);
            sessionStorage.setItem('conversationId', conversationId);
            sessionStorage.setItem('roomType', roomType);
            sessionStorage.setItem('roomName', roomName);
            sessionStorage.setItem('roomImageUrl', roomImageUrl);
            sessionStorage.setItem('roomImageUrlAlt', roomImageUrlAlt);
            sessionStorage.setItem('handle', handle);

            fetch(`/chat/` + conversationId)
                .then(response => response.json())
                .then(data => {
                    const isMember = data['is_member'];
                    sessionStorage.setItem('isMember', isMember);

                    const message = document.querySelector('#message');
                    const messageJoin = document.querySelector('#message_join');

                    const introduction = document.querySelector('#introduction');
                    introduction.classList.add('hidden');
                    
                    const chat = document.querySelector('#chat');
                    chat.classList.remove('hidden');

                    const leaveElement = document.querySelector('#leave');

                    if (isMember) {
                        message.classList.remove('hidden');
                        message.classList.add('flex');
                        messageJoin.classList.add('hidden');

                        leaveElement.classList.remove('hidden');
                        leaveElement.onclick = () => leave(userId, conversationId);
                    } else {
                        message.classList.add('hidden');
                        messageJoin.classList.remove('hidden');
                        messageJoin.onclick = () => join(userId, conversationId);

                        leaveElement.classList.add('hidden');
                    }

                    const chatroomWrapper = document.querySelector(`#room-${conversationId}`);
                    const roomNameElement = document.querySelector('#room-name');
                    const roomNameWrapperElement = document.querySelector('#room-name-wrapper');
                    const roomIconElement = document.querySelector('#room-icon');
                    const roomIconWrapperElement = document.querySelector('#room-icon-wrapper');
                    const chatrooms = document.querySelector('#chatrooms');
                    const divs = chatrooms.querySelectorAll('div');

                    divs.forEach(div => {
                        if (div.classList.contains('bg-gray-200')) {
                            div.classList.remove('bg-gray-200');
                            div.classList.add('hover:bg-gray-100');
                        }
                    });

                    chatroomWrapper.classList.add('bg-gray-200');
                    chatroomWrapper.classList.remove('hover:bg-gray-100');

                    const baseUrl = window.location.protocol + "//" + window.location.hostname;
                    roomNameWrapperElement.href = `${baseUrl}/corners/${handle}`;
                    roomNameWrapperElement.target = '_blank';
                    roomNameWrapperElement.rel = 'noopener noreferrer';
                    
                    roomIconWrapperElement.href = `${baseUrl}/corners/${handle}`;
                    roomIconWrapperElement.target = '_blank';
                    roomIconWrapperElement.rel = 'noopener noreferrer';

                    if (roomType === 'group') {
                        roomIconElement.classList.add('rounded-lg');
                    } else {
                        roomIconElement.classList.remove('rounded-lg');
                    }

                    roomNameElement.innerText = roomName;
                    roomIconElement.src = roomImageUrl;
                    roomIconElement.alt = roomImageUrlAlt;

                    renderMessages(data['messages']);
                });
        }

        function leave(userId, conversationId) {
            const formData = new FormData();
            formData.append('userId', userId);
            formData.append('conversationId', conversationId);

            fetch('/chat/leave', {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: formData,
            })
            .then(response => response.json())
            .then(data => {
                const leaveElement = document.querySelector('#leave');
                leaveElement.classList.add('hidden');

                // hide message input
                const message = document.querySelector('#message');
                message.classList.add('hidden');

                const messageJoin = document.querySelector('#message_join');
                messageJoin.classList.remove('hidden');
                messageJoin.onclick = () => join(userId, conversationId);
            });
        }

        function renderMessages(messages) {
            const chat = document.querySelector('#chat');
            chat.innerHTML = '';

            const currentUserId = JSON.parse(sessionStorage.getItem('userId'));

            for (const message of messages) {
                if (!message['user']) {
                    const messageElement = createSystemMessage(message);
                    chat.appendChild(messageElement);
                } else {
                    if (currentUserId === message['user_id']) {
                        const messageElement = createMyMessage(message['content']);
                        chat.appendChild(messageElement);
                    } else {
                        const messageElement = createOppositeMessage(message);
                        chat.appendChild(messageElement);
                    }
                }
            }
        }

        function createMyMessage(message) {
            const div = document.createElement('div');
            div.classList.add('flex');
            div.classList.add('justify-end');

            const innerDiv = document.createElement('div');
            innerDiv.classList = 'bg-green-200 py-1 px-2 rounded-lg w-max border border-black/20 grid';
            innerDiv.innerText = message;

            div.appendChild(innerDiv);
            return div;
        }

        function createOppositeMessage(message) {
            let baseUrl = window.location.protocol + "//" + window.location.hostname + "/";

            const div = document.createElement('div');
            div.classList.add('flex');
            div.classList.add('gap-2');

            const imageWrapper = document.createElement('a');
            imageWrapper.href = `${baseUrl}users/${message['user']['username']}`;
            imageWrapper.target = '_blank';
            imageWrapper.rel = 'noopener noreferrer';

            const image = document.createElement('img');
            image.classList = 'w-8 h-8 inline rounded-full';
            image.src = '/img/user.png';
            image.alt = 'user.png';

            imageWrapper.append(image);

            if (message['user']['image_url']) {
                image.src = `${baseUrl}/storage/icons/${message['user']['image_url']}`;
            }

            const innerDiv = document.createElement('div');
            const p = document.createElement('p');

            const pWrapper = document.createElement('a');
            pWrapper.href = `${baseUrl}users/${message['user']['username']}`;
            pWrapper.target = '_blank';
            pWrapper.rel = 'noopener noreferrer';
            pWrapper.classList = 'w-max inline-block leading-tight';

            p.classList ='text-sm w-max';

            const span = document.createElement('span');
            span.classList = 'font-bold leading-tight';

            span.innerText = message['user']['name'];

            p.appendChild(span);
            pWrapper.appendChild(p);

            const contentDiv = document.createElement('div');
            contentDiv.classList = 'text-sm bg-gray-200 mt-1 py-1 px-2 rounded-lg w-max h-max border border-black/20';
            contentDiv.innerText = message['content'];

            innerDiv.appendChild(pWrapper);
            innerDiv.appendChild(contentDiv);

            div.appendChild(imageWrapper);
            div.appendChild(innerDiv);

            return div;
        }

        function createSystemMessage(message) {
            const div = document.createElement('div');
            div.classList = 'flex justify-center';

            const p = document.createElement('p');
            p.classList = 'bg-gray-200 text-sm py-1 px-2 rounded-lg w-max border border-black/20 grid';

            if (message['content'] === 'user_joined') {
                p.innerText = `${message['target_user']['username']} has joined the group`;
            } else if (message['content'] === 'user_left') {
                p.innerText = `${message['target_user']['username']} has left the group`;
            } else {
                p.innerText = message['content'];
            }

            div.appendChild(p);

            return div;
        }
    </script>
</body>
</html>