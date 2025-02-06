@php
    function getClass(String $name, $errors): String {
        $baseClass = " shadow appearance-none border rounded w-full py-2 px-3 leading-tight focus:outline-none focus:shadow-outline";
        $classValid = "text-gray-700";
        $classInvalid = "border border-red-500 text-red-500 placeholder-red-500";
        
        if (!empty($errors) && $errors->has($name)) {
            return $baseClass . $classInvalid;
        }
        return $baseClass . $classValid;
    }

    function getDefaultClass() {
        $baseClass = " shadow appearance-none border rounded w-full py-3 px-3 leading-tight focus:outline-none focus:shadow-outline";
        $classValid = "text-gray-700";
        return $classValid . $baseClass;
    }
@endphp

<x-layout>
    <form id="editDialog" class="hidden w-screen h-screen absolute z-20 bg-black/10">
        <div class="m-auto w-5/6 lg:w-2/6 h-max bg-white border-gray-500 rounded-md space-y-3 p-4">
            <div class="flex justify-between">
                <h2 id="title" class="text-sm lg:text-lg font-bold">Edit Something</h2>
                <x-heroicon-o-x-mark class="w-6 h-6 text-gray-500 cursor-pointer" onclick="closeEdit()" />
            </div>
            <input type="hidden" id="type">
            <input type="hidden" id="old">
            <input class="{{ getClass('input', $errors) }} text-xs lg:text-md" name="input" id="input" type="text" placeholder="new something" />
            <div class="flex pt-4">
                <button class="text-sm lg:text-base bg-blue-500 rounded-lg py-1 px-3 lg:px-4 text-white ml-auto grid" style="grid-template-areas: stack" type="submit">
                    <span id="SubmitBtnLabel" style="grid-area: stack">Save</span>
                    <svg id="SubmitBtnLoading" class="invisible m-auto animate-spin h-5 w-5 text-white" style="grid-area: stack" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        <path d="M4 12a8 8 0 0116 0" stroke="currentColor" stroke-width="4" fill="none"></path>
                    </svg>
                </button>
            </div>
        </div>
    </form>
    <div class="flex justify-between md:gap-8 pt-12 md:pt-16">
        <x-left />
        <div class="w-full">
            <div class="mx-auto px-8 py-4">
                <h1 class="text-md lg:text-lg text-gray-700 font-bold">Members</h1>
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4">
                    @foreach ($corner->members as $member)
                        <x-corners.member :$authorized :cornerId="$corner->id" :$member />
                    @endforeach
                </div>
            </div>
        </div>
        <x-trending />
    </div>
</x-layout>