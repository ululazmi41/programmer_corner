<x-layout>
    <div class="flex md:gap-4 pt-4 md:pt-16">
        <x-left />
        <div class="w-full md:w-3/5 py-8 px-4 md:p-0 md:pb-4">
            <div class="grid gap-4 m-auto w-full md:w-3/5">
                @foreach ($user->followers as $follow)
                    <x-user.follow-card :user="$follow" />
                @endforeach
            </div>
        </div>
        <x-trending />
    </div>
    </script>
</x-layout>