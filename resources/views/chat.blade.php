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
                            '{{ $room['corner_id'] }}',
                            '{{ $room['handle'] }}');" />
                @endforeach
            </div>
        </div>
        <div class="w-4/5 px-4 pt-2 pb-4 flex flex-col">
            <div class="flex justify-between">
                <div class="flex gap-2 p-2 items-center transition">
                    <a id="room-icon-wrapper" href="#">
                        <Image id="room-icon" class="w-8 h-8 hidden" src="" alt="" />
                    </a>
                    <a id="room-name-wrapper" href="#">
                        <p id="room-name" class="leading-tight text-sm font-bold"></p>
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
            const roomType = sessionStorage.getItem('roomType');
            const roomName = sessionStorage.getItem('roomName');
            const roomImageUrl = sessionStorage.getItem('roomImageUrl');
            const conversationId = sessionStorage.getItem('conversationId');
            const roomImageUrlAlt = sessionStorage.getItem('roomImageUrlAlt');
            const cornerId = sessionStorage.getItem('cornerId');
            const handle = sessionStorage.getItem('handle');

            if (roomId) {
                select(roomId, {{ Auth::id() }}, conversationId, roomType, roomName, roomImageUrl, roomImageUrlAlt, cornerId, handle);
            }
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

                const input = document.querySelector('#message');
                input.value = '';
            });
        });

        function join(userId, cornerId, conversationId) {
            const formData = new FormData();
            formData.append('userId', userId);
            formData.append('cornerId', cornerId);
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
                sessionStorage.setItem('role', 'member');

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

        function select(roomId, userId, conversationId, roomType, roomName, roomImageUrl, roomImageUrlAlt, cornerId, handle) {
            sessionStorage.setItem('roomId', roomId);
            sessionStorage.setItem('userId', userId);
            sessionStorage.setItem('conversationId', conversationId);
            sessionStorage.setItem('roomType', roomType);
            sessionStorage.setItem('roomName', roomName);
            sessionStorage.setItem('roomImageUrl', roomImageUrl);
            sessionStorage.setItem('roomImageUrlAlt', roomImageUrlAlt);
            sessionStorage.setItem('cornerId', cornerId);
            sessionStorage.setItem('handle', handle);

            fetch(`/chat/` + conversationId)
                .then(response => response.json())
                .then(data => {
                    sessionStorage.setItem('role', data['role']);

                    const message = document.querySelector('#message');
                    const messageJoin = document.querySelector('#message_join');

                    const introduction = document.querySelector('#introduction');
                    introduction.classList.add('hidden');
                    
                    const chat = document.querySelector('#chat');
                    chat.classList.remove('hidden');

                    const leaveElement = document.querySelector('#leave');
                    const isMember = data['role'] !== 'inactive';

                    if (isMember) {
                        message.classList.remove('hidden');
                        message.classList.add('flex');
                        messageJoin.classList.add('hidden');

                        leaveElement.classList.remove('hidden');
                        leaveElement.onclick = () => leave(userId, conversationId);
                    } else {
                        message.classList.add('hidden');
                        messageJoin.classList.remove('hidden');
                        messageJoin.onclick = () => join(userId, cornerId, conversationId);

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
                    roomIconElement.classList.remove('hidden');
                    roomIconElement.classList.add('inline');

                    renderMessages(data['messages'], data['role']);
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

                const cornerId = sessionStorage.getItem('cornerId');
                messageJoin.onclick = () => join(userId, cornerId, conversationId);
            });
        }

        function renderMessages(messages, role) {
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
                        const messageElement = createOppositeMessage(message, role);
                        chat.appendChild(messageElement);

                        document.addEventListener('click', () => {
                            const dropdownToggle = document.getElementById(`message-${message['id']}-dropdown-toggle`);
                            const dropdownMenu = document.getElementById(`message-${message['id']}-dropdown-menu`);

                            if (dropdownMenu !== null) {
                                if (!dropdownMenu.contains(event.target) && event.target !== dropdownToggle) {
                                    dropdownToggle.checked = false;
                                }
                            }
                        });
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

        function createOppositeMessage(message, role) {
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

            const nameMenus = document.createElement('div');
            nameMenus.classList = 'flex gap-2';

            const pWrapper = document.createElement('a');
            pWrapper.href = `${baseUrl}users/${message['user']['username']}`;
            pWrapper.target = '_blank';
            pWrapper.rel = 'noopener noreferrer';
            pWrapper.classList = 'w-max inline-block';

            const p = document.createElement('p');
            p.classList ='w-max font-bold';
            p.innerText = message['user']['name'];

            pWrapper.appendChild(p);

            nameMenus.appendChild(pWrapper);

            if (role === 'owner' || role === 'admin') {
                const wrapper = document.createElement('div');
                wrapper.classList = 'relative inline-block text-left';

                const input = document.createElement('input');
                input.type = 'checkbox';
                input.id = `message-${message['id']}-dropdown-toggle`;
                input.classList = 'hidden peer';

                const label = document.createElement('label');
                label.setAttribute('for', `message-${message['id']}-dropdown-toggle`);
                label.innerText = '⋯';
                label.classList = 'text-lg cursor-pointer';

                const menuWrapper = document.createElement('div');
                menuWrapper.id = `message-${message['id']}-dropdown-menu`;
                menuWrapper.classList = 'hidden peer-checked:block absolute left-0 z-10 mt-2 origin-top-left rounded-md bg-white shadow-lg ring-1 ring-black/5 focus:outline-none';
                menuWrapper.role = 'menu';
                menuWrapper.setAttribute('aria-orientation', 'vertical');
                menuWrapper.setAttribute('aria-labelledby', 'menu-button');

                const itemsWrapper = document.createElement('div');
                itemsWrapper.classList = 'py-2 px-1 grid gap-2';
                itemsWrapper.role = 'none';

                const button = document.createElement('button');

                button.onclick = () => {
                    remove(message['user_id'], message['conversation_id']);
                    input.checked = false;
                };
                button.classList = 'flex gap-2 items-center px-4 text-sm text-gray-500 hover:text-gray-700';
                button.role = 'menuitem';
                button.id = 'menu-item-1';
                button.innerText = 'remove';

                itemsWrapper.appendChild(button);
                menuWrapper.appendChild(itemsWrapper);

                wrapper.appendChild(input);
                wrapper.appendChild(label);
                wrapper.appendChild(menuWrapper);

                nameMenus.appendChild(wrapper);
            }

            const contentDiv = document.createElement('div');
            contentDiv.classList = 'text-sm bg-gray-200 mt-1 py-1 px-2 rounded-lg w-max h-max border border-black/20';
            contentDiv.innerText = message['content'];

            innerDiv.appendChild(nameMenus);
            innerDiv.appendChild(contentDiv);

            div.appendChild(imageWrapper);
            div.appendChild(innerDiv);

            return div;
        }

        function remove(userId, conversationId) {
            const formData = new FormData();
            formData.append('userId', userId);
            formData.append('conversationId', conversationId);
            
            fetch('/chat/rem', {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: formData,
            });
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