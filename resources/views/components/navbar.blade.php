<div class="w-full border-b-gray-400 fixed z-20 bg-white/90">
    <div class="flex pr-3 justify-between sm:px-12 py-2 items-center">
        <div class="flex items-center">
            <div class="pl-3 mr-3 relative sm:hidden inline-block text-left">
                <x-heroicon-o-bars-3 id="menuDropdownToggle" class="w-6 h-6 text-gray-400 cursor-pointer hover:text-gray-500" />

                <div id="menuDropdownMenu"
                    class="hidden absolute left-0 z-10 mt-2 w-screen h-screen origin-top-left rounded-md bg-white shadow-lg ring-1 ring-black/5 focus:outline-none"
                    role="menu" aria-orientation="vertical" aria-labelledby="menu-button" tabindex="-1">
                    <div class="py-2 px-1 grid gap-1" role="none">
                        <x-left-mobile />
                    </div>
                </div>
            </div>

            <p class="text-blue-500 text-xl font-bold cursor-default select-none">Pi</p>
        </div>
        <form class="hidden sm:block w-2/6" action="/search" method="POST">
            @csrf
            <input
                class="w-full text-gray-700 shadow appearance-none border rounded py-2 px-3 leading-tight focus:outline-none focus:shadow-outline"
                name="search" id="search" type="text" placeholder="Search" />
        </form>
        @auth
            <div class="flex gap-2">
                <a href="/search">
                    <x-heroicon-o-magnifying-glass
                        class="block sm:hidden w-6 h-6 text-gray-400 cursor-pointer hover:text-gray-500" />
                </a>
                <x-heroicon-o-bell class="w-6 h-6 text-gray-400 cursor-pointer hover:text-gray-500" />
                <div class="relative inline-block text-left">
                    <input type="checkbox" id="authDropdownToggle" class="hidden peer" />
                    <label for="authDropdownToggle">
                        <x-heroicon-o-user-circle class="w-6 h-6 text-gray-400 cursor-pointer" />
                    </label>

                    <div id="authDropdownMenu"
                        class="hidden peer-checked:block absolute right-0 z-10 mt-2 w-48 origin-top-right rounded-md bg-white shadow-lg ring-1 ring-black/5 focus:outline-none"
                        role="menu" aria-orientation="vertical" aria-labelledby="menu-button" tabindex="-1">
                        <div class="py-2 px-1 grid gap-1" role="none">
                            <a href="#" class="flex gap-2 items-center px-4 py-2 text-md text-gray-700"
                                role="menuitem" tabindex="-1" id="menu-item-0">
                                <x-heroicon-c-user-circle class="w-4 h-4" />
                                Profile
                            </a>
                            <a href="/logout" class="flex gap-2 items-center px-4 py-2 text-md text-gray-700"
                                role="menuitem" tabindex="-1" id="menu-item-1">
                                <Image class="w-4 h-4 inline" src="/img/register.png" alt="register icon" />
                                Logout
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @endauth
        @guest
            <div class="flex gap-2 sm:gap-4 items-center">
                <a href="/login">
                    <button
                        class="w-full text-xs sm:text-base bg-blue-500 hover:opacity-70 text-white py-1 px-2 sm:px-4 rounded-lg focus:outline-none focus:shadow-outline transform transition duration-150">
                        Login
                    </button>
                </a>
                <div class="relative inline-block text-left">
                    <input type="checkbox" id="guestDropdownToggle" class="hidden peer" />
                    <label for="guestDropdownToggle">
                        <x-heroicon-o-ellipsis-horizontal class="w-6 sm:w-8 cursor-pointer" />
                    </label>

                    <div id="guestDropdownMenu"
                        class="hidden peer-checked:block absolute right-0 z-10 mt-2 w-48 origin-top-right rounded-md bg-white shadow-lg ring-1 ring-black/5 focus:outline-none"
                        role="menu" aria-orientation="vertical" aria-labelledby="menu-button" tabindex="-1">
                        <div class="py-2 px-1 grid gap-1" role="none">
                            <a href="/register" class="flex text-sm sm:text-md gap-2 items-center px-4 py-2 text-gray-700"
                                role="menuitem" tabindex="-1" id="menu-item-0">
                                <Image class="w-4 h-4 inline" src="/img/register.png" alt="register icon" />
                                Register
                            </a>
                            <a href="/login" class="flex text-sm sm:text-md gap-2 items-center px-4 py-2 text-gray-700"
                                role="menuitem" tabindex="-1" id="menu-item-1">
                                <Image class="w-4 h-4 inline" src="/img/login.png" alt="register icon" />
                                Login
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @endguest
    </div>

    <script>
        // Mobile Menu
        const menuDropdownToggle = document.getElementById('menuDropdownToggle');
        const menuDropdownMenu = document.getElementById('menuDropdownMenu');

        menuDropdownToggle.addEventListener('click', () => {
            menuDropdownMenu.classList.toggle('block');
            menuDropdownMenu.classList.toggle('hidden');
        });

        // Guest
        const guestDropdownToggle = document.getElementById('guestDropdownToggle');
        const guestDropdownMenu = document.getElementById('guestDropdownMenu');

        if (guestDropdownMenu !== null) {
            menuDropdownToggle.addEventListener('click', () => {
                if (!guestDropdownMenu.contains(event.target) && event.target !== guestDropdownToggle) {
                    guestDropdownToggle.checked = false;
                }
            });
        }

        // Auth
        const authDropdownToggle = document.getElementById('authDropdownToggle');
        const authDropdownMenu = document.getElementById('authDropdownMenu');

        if (authDropdownMenu !== null) {
            authDropdownToggle.addEventListener('click', () => {
                if (!authDropdownMenu.contains(event.target) && event.target !== authDropdownToggle) {
                    authDropdownToggle.checked = false;
                }
            });
        };

        document.addEventListener('click', () => {
            // Guest
            const guestDropdownToggle = document.getElementById('guestDropdownToggle');
            const guestDropdownMenu = document.getElementById('guestDropdownMenu');

            if (guestDropdownMenu !== null) {
                if (!guestDropdownMenu.contains(event.target) && event.target !== guestDropdownToggle) {
                    guestDropdownToggle.checked = false;
                }
            }

            // Auth
            const authDropdownToggle = document.getElementById('authDropdownToggle');
            const authDropdownMenu = document.getElementById('authDropdownMenu');

            if (authDropdownMenu !== null) {
                if (!authDropdownMenu.contains(event.target) && event.target !== authDropdownToggle) {
                    authDropdownToggle.checked = false;
                }
            }
        });
    </script>
</div>
