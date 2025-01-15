@props(['user'])

<div>
    <div class="flex justify-between items-center">
        <div class="flex items-center gap-4">
            <a href="{{ route('users.show', ['username' => $user->username]) }}">
                <image id="icon" class="w-8 h-8 md:w-12 md:h-12 rounded-full" src="{{ $user["image_url"] ? asset('storage/icons/' . $user["image_url"]) : "/img/user.png" }}" alt="profile picture" />
            </a>
            <div>
                <a href="{{ route('users.show', ['username' => $user->username]) }}">
                    <div class="text-sm md:text-md font-semibold">{{ $user->name }}</div>
                </a>
                <a href="{{ route('users.show', ['username' => $user->username]) }}">
                    <div class="text-sm md:text-md text-gray-500">{{ '@' }}{{ $user->username }}</div>
                </a>
            </div>
        </div>
        <div>
            @if (Auth::id() !== $user->id)
                <button
                    id="follow-{{ $user->id }}"
                    onclick="follow('{{ $user->id }}', '{{ $user->username }}');"
                    class="{{ $user->followers->contains('id', Auth::id()) ? "hidden" : "" }} h-max text-sm font-semibold lg:text-base bg-blue-500 hover:bg-blue-400 transition transform duration-100 rounded-2xl py-1 px-3 lg:px-4 text-white ml-auto"
                >+ follow</button>
                <button
                    id="unfollow-{{ $user->id }}"
                    onclick="unfollow('{{ $user->id }}', '{{ $user->username }}');"
                    class="{{ $user->followers->contains('id', Auth::id()) ? "" : "hidden" }} h-max text-sm font-semibold lg:text-base bg-black/40 hover:bg-black/30 transition transform duration-100 rounded-2xl py-1 px-3 lg:px-4 text-white ml-auto"
                >✓ following</button>
            @endif
        </div>
    </div>
    <div class="text-sm md:text-md text-gray-500">{{ $user->description }}</div>

    <script>
        function toggleFollowButton(userId) {
            const followButton = document.querySelector(`#follow-${userId}`);
            const unfollowButton = document.querySelector(`#unfollow-${userId}`);
            followButton.classList.toggle('hidden');
            unfollowButton.classList.toggle('hidden');
        }

        async function follow(userId, username) {
            await helper_follow(userId, username, '{{ $user->username }}');
            toggleFollowButton(userId);
        }

        async function unfollow(userId, username) {
            await helper_unfollow(userId, username, '{{ $user->username }}');
            toggleFollowButton(userId);
        }
    </script>
</div>