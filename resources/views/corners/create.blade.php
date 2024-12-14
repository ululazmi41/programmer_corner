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
<div class="flex justify-between md:gap-8 pt-12 md:pt-16">
    <x-left />
    <div class="w-full">
        <div class="mx-auto">
            <div class="w-full h-24 bg-gray-300 rounded-tl-lg rounded-tr-lg"></div>
            <div class="flex my-4 gap-4 items-center">
                <Image class="w-12 h-12" src="/img/group.png" alt="group.png" />
                <div class="flex flex-col">
                    <p class="font-semibold">Untitled</p>
                    <p class="text-gray-500 text-sm">1 member • 1 online</p>
                    <p class="text-sm">Description.</p>
                </div>
            </div>
            <h1 class="text-md lg:text-2xl text-gray-700 font-bold">Create Corner</h1>
        </div>
    </div>
    <x-right />
</div>
</x-layout>
