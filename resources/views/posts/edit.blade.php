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
        <div class="w-full md:w-3/5 px-4 lg:p-0">
            <form class="mx-auto" action="{{ route('posts.update', ['post' => $post->id]) }}" method="POST">
                @csrf
                @method("PUT")
                <input type="hidden" name="corner_id" value="{{ $corner['id'] }}">
                <h1 class="text-md lg:text-xl text-gray-700 font-bold">Edit Post</h1>
                <div class="flex my-4 py-1 px-2 rounded-md gap-2 items-center border bg-gray-100 border-gray-300 w-max">
                    <Image class="w-6 h-6 rounded-full" src="{{ $corner["icon_url"] ? asset("storage/icons/" . $corner["icon_url"]) : "/img/group.png" }}" alt="{{ $corner["icon_url"] ? $corner["icon_url"] : "group.png" }}" />
                    <p class="text-xs text-gray-500">{{ $corner->name }}</p>
                </div>
                <input class="{{ getClass('title', $errors) }} text-xs sm:text-md lg:text-base" name="title" id="title"
                    type="text" placeholder="Title" value="{{ old('title', $post->title) }}" />
                <div class="h-4"></div>
                <textarea id="message" rows="4" name="content"
                    class="block p-2.5 w-full text-xs lg:text-base text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    placeholder="Content">{{ old('content', $post->content) }}</textarea>
                <div class="flex pt-4">
                    <button class="text-sm lg:text-base bg-blue-500 rounded-lg py-1 px-3 lg:px-4 text-white ml-auto" type="submit">
                        Edit
                    </button>
                </div>
            </form>
        </div>
        <x-trending />
    </div>
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            alter('title');
            alter('content');
        });

        function alter(id) {
            const render = document.querySelector(`#render-${id}`);
            const input = document.querySelector(`#${id}`);
            if (input.value != "") {
                render.innerText = input.value;
            } else {
                render.innerText = "Untitle";
            }
        }
    </script>
</x-layout>
