@props(['content', 'type'])

@php
    $editURL = '';
    $deleteAction = '';

    if ($type === \App\Enums\ContentType::POST) {
        $editURL = route('posts.edit', ['post' => $content->id]);
        $deleteAction = route('posts.destroy', ['id' => $content->id]);
    } else if ($type === \App\Enums\ContentType::COMMENT) {
        $deleteAction = route('comments.destroy', ['id' => $content->id]);
    } else {
        //
    }
@endphp

@auth
    @if ($content->user_id == Auth::id())
        <div class="relative inline-block text-left">
            <input type="checkbox" id="comment-{{ $content->id }}-dropdown-toggle" class="hidden peer" />
            <label for="comment-{{ $content->id }}-dropdown-toggle">
                <x-heroicon-o-ellipsis-horizontal class="w-6 h-6 text-gray-400 cursor-pointer" />
            </label>

            <div id="comment-{{ $content->id }}-dropdown-menu"
                class="hidden peer-checked:block absolute right-0 z-10 mt-2 origin-top-right rounded-md bg-white shadow-lg ring-1 ring-black/5 focus:outline-none"
                role="menu" aria-orientation="vertical" aria-labelledby="menu-button" tabindex="-1">
                <div class="py-2 px-1 grid gap-2" role="none">
                    @if ($editURL !== '')
                        <a
                            href="{{ $editURL }}"
                            class="flex gap-2 items-center px-4 text-sm text-gray-500 hover:text-gray-700"
                            role="menuitem" tabindex="-1" id="menu-item-1">
                            edit
                        </a>
                    @endif
                    <form
                        action="{{ $deleteAction }}"
                        method="POST"
                        class="flex gap-2 items-center px-4 text-sm text-gray-500 hover:text-gray-700"
                        role="menuitem" tabindex="-1" id="menu-item-2">
                        @csrf
                        @method("DELETE")
                        <button type="submit">delete</button>
                    </form>
                </div>
            </div>
        </div>
    @endif
@endauth