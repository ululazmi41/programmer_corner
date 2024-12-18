@php
    function getClass(string $name, $errors): string
    {
        $baseClass =
            ' shadow appearance-none border rounded w-full py-2 px-3 leading-tight focus:outline-none focus:shadow-outline';
        $classValid = 'text-gray-700';
        $classInvalid = 'border border-red-500 text-red-500 placeholder-red-500';

        if (!empty($errors) && $errors->has($name)) {
            return $baseClass . $classInvalid;
        }
        return $baseClass . $classValid;
    }

    function getDefaultClass()
    {
        $baseClass =
            ' shadow appearance-none border rounded w-full py-3 px-3 leading-tight focus:outline-none focus:shadow-outline';
        $classValid = 'text-gray-700';
        return $classValid . $baseClass;
    }
@endphp

<x-layout>
    <div class="flex justify-between md:gap-8 pt-12 md:pt-16">
        <x-left />
        <div class="w-full md:w-3/5">
            <form class="mx-auto" action="create-corner" method="POST" enctype="multipart/form-data">
                @csrf
                <div>
                    <div id="bannerPlaceholder" class="w-full h-24 bg-gray-300 rounded-tl-lg rounded-t-lg"></div>
                    <img src="/`img/dart.jpg" id="imgBanner" alt="banner" class="hidden w-full h-24 object-cover rounded-t-lg transition-all duration-300 ease-in-out" />
                </div>
                <div class="flex my-4 gap-4 items-center">
                    <Image id="imgIcon" class="w-12 h-12" src="/img/group.png" alt="icon image" />
                    <div class="flex flex-col">
                        <p class="font-semibold">Untitled</p>
                        <p class="text-gray-500 text-sm">1 member • 1 online</p>
                        <p class="text-sm">Description.</p>
                    </div>
                </div>

                <h1 class="text-md lg:text-xl text-gray-700 font-bold">Create Corner</h1>

                <div class="space-y-2">
                    <input type="file" name="icon" id="fileIcon" class="w-0 h-0 opacity-0 absolute" accept="image/*"
                    onchange="addImage(event, 'Icon')">
                    <input type="file" name="banner" id="fileBanner" class="w-0 h-0 opacity-0 absolute" accept="image/*"
                        onchange="addBanner(event, 'Banner')">

                    <div class="flex gap-2 items-center">
                        <button type="button" onclick="clickImage('Icon')"
                            class="flex items-center border border-blue-500 hover:bg-blue-500 rounded-md px-2 lg:px-3 lg:py-1 text-sm text-blue-500 hover:text-white">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                            </svg>
                            Add Icon</button>
                        <x-heroicon-s-trash id="deleteIcon" onclick="deleteImage('Icon')"
                            class="hidden w-5 h-5 lg:w-6 lg:h-6 text-red-400 hover:text-red-500 cursor-pointer" />
                    </div>
                    <div class="flex gap-2 items-center">
                        <button type="button" onclick="clickImage('Banner')"
                            class="flex items-center border border-blue-500 hover:bg-blue-500 rounded-md px-2 lg:px-3 lg:py-1 text-sm text-blue-500 hover:text-white">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                            </svg>
                            Add Banner</button>
                        <x-heroicon-s-trash id="deleteBanner" onclick="deleteBanner('Banner')"
                            class="hidden w-5 h-5 lg:w-6 lg:h-6 text-red-400 hover:text-red-500 cursor-pointer" />
                    </div>
                </div>

                <div class="h-4"></div>
                <input class="{{ getClass('name', $errors) }} text-xs lg:text-md" name="name" id="name"
                    type="text" placeholder="Name" value="{{ old('name') }}" />
                <div class="h-4"></div>
                <textarea id="message" rows="4" name="description"
                    class="block p-2.5 w-full text-xs lg:text-md text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    placeholder="Description"></textarea>
                </textarea>
                <div class="flex pt-4">
                    <button class="text-sm lg:text-base bg-blue-500 rounded-lg py-1 px-3 lg:px-4 text-white ml-auto" type="submit">
                        Save
                    </button>
                </div>
            </form>
        </div>
        <x-right :$trendingPosts />
    </div>
    <script>
        function deleteBanner(type) {
            const gray = document.querySelector('#bannerPlaceholder');
            const img = document.querySelector(`#img${type}`);

            if (gray.classList.contains('hidden')) {
                gray.classList.remove('hidden');
            }
            if (!img.classList.contains('hidden')) {
                img.classList.add('hidden');
            }

            deleteImage(type);
        }

        function clickImage(type) {
            const file = document.querySelector(`#file${type}`);
            file.click();
        }

        function deleteImage(type) {
            const img = document.querySelector(`#img${type}`);

            if (type === "Icon") {
                img.src = "/img/group.png";
            } else {
                img.src = "";
            }

            const deleteButton = document.querySelector(`#delete${type}`);
            if (!deleteButton.classList.contains("hidden")) {
                deleteButton.classList.add("hidden");
            }
        }

        function addBanner(event, type) {
            const gray = document.querySelector('#bannerPlaceholder');
            const img = document.querySelector(`#img${type}`);

            if (!gray.classList.contains('hidden')) {
                gray.classList.toggle('hidden');
            }
            if (img.classList.contains('hidden')) {
                img.classList.remove('hidden');
            }

            addImage(event, type);
        }

        function addImage(event, type) {
            console.log(event, type);
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const url = e.target.result;
                    const img = document.querySelector(`#img${type}`);
                    img.src = url;
                }
                reader.readAsDataURL(file);

                const deleteButton = document.querySelector(`#delete${type}`);
                if (deleteButton.classList.contains("hidden")) {
                    deleteButton.classList.remove("hidden");
                }
            }
        }
    </script>
</x-layout>
