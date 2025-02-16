@props(['room', 'onclick'])

<div id="room-{{ $room['id'] }}" onclick="{{ $onclick }}" class="flex gap-2 p-2 items-center hover:bg-gray-200 transition cursor-pointer">
    <Image class="w-10 h-10 inline {{ $room['type'] === 'group' ? 'rounded-lg' : '' }}" src="{{ $room['image_url'] ? asset('storage/icons/' . $room['image_url']) : 'group.png' }}" alt="{{ $room['image_url'] ?? 'group.png' }}" />
    <div>
        <p class="leading-tight text-sm font-bold">{{ $room['name'] }}</p>
        @if ($room['last_message_content'] !== null)
            <p class="leading-tight text-sm">
                {{ $room['last_message_user_id'] === Auth::id() ? "you" : $room['last_message_user_name'] }}: {{ $room['last_message_content'] }}
            </p>
        @endif
    </div>
</div>