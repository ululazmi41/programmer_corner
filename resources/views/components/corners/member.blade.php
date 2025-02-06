@props(['member', 'cornerId', 'authorized'])

<div class="flex justify-between items-center">
    <div class="flex items-center gap-2">
        <a href="{{ route('users.show', ['username' => $member->username]) }}">
            <image class="w-10 h-10 my-2 rounded-full" src="{{ $member->image_url ? asset('storage/icons/' . $member->image_url) : "/img/user.png" }}" alt="user.png" />
        </a>
        <div>
            <p class="text-sm">
                <a href="{{ route('users.show', ['username' => $member->username]) }}">
                    <span class="font-semibold">{{ $member->name }}</span>
                </a>
                @if ($member->pivot->role === 'owner')
                    <span class="text-green-700">({{ $member->pivot->role }})</span>
                @elseif ($member->pivot->role === 'admin')
                    <span class="text-blue-700">({{ $member->pivot->role }})</span>
                @endif
            </p>
            <a href="{{ route('users.show', ['username' => $member->username]) }}">
                <p class="text-xs text-gray-500">{{ '@' }}{{ $member->username }}</p>
            </a>
        </div>
    </div>
    @auth
        @if ($authorized && $member->pivot->role !== 'owner' && $member->id !== Auth::id())
        <div class="relative">
            <input type="checkbox" id="dropdown-toggle-{{ $member->id }}" class="hidden peer" />
            <label for="dropdown-toggle-{{ $member->id }}">
                <x-heroicon-o-ellipsis-horizontal class="w-8 h-8 text-gray-400 hover:text-gray-600 cursor-pointer" />
            </label>

            <div id="dropdown-menu-{{ $member->id }}"
                class="hidden peer-checked:block w-max absolute right-0 z-10 mt-2 origin-top-right rounded-md bg-white shadow-lg ring-1 ring-black/5">
                <div class="py-2 px-1 grid gap-2">
                        <form
                            action="{{ route('corners.members.updateRole', ['corner' => $cornerId, 'member' => $member->id]) }}"
                            method="POST"
                            class="flex gap-2 items-center px-4 text-sm text-gray-500 hover:text-gray-700"
                            role="menuitem" tabindex="-1" id="menu-item-1">
                            @csrf
                            @if ($member->pivot->role === "member")
                                <input type="hidden" name="role" value="admin">
                                <button type="submit">set as admin</button>
                            @elseif ($member->pivot->role === "admin")
                                <input type="hidden" name="role" value="member">
                                <button type="submit">demote to member</button>
                            @endif
                        </form>
                    <form
                        action="/comments/{{ $member->id }}"
                        method="POST"
                        class="flex gap-2 items-center px-4 text-sm text-gray-500 hover:text-gray-700"
                        role="menuitem" tabindex="-1" id="menu-item-1">
                        @csrf
                        @method("DELETE")
                        <button type="submit">kick</button>
                    </form>
                </div>
            </div>
        </div>
        @endif
    @endauth
</div>
<script>
    document.addEventListener('click', () => {
        const dropdownToggle = document.getElementById('dropdown-toggle-{{ $member->id }}');
        const dropdownMenu = document.getElementById('dropdown-menu-{{ $member->id }}');

        if (dropdownMenu !== null) {
            if (!dropdownMenu.contains(event.target) && event.target !== dropdownToggle) {
                dropdownToggle.checked = false;
            }
        }
    });
</script>