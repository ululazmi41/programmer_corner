@php
    $classValid = "text-gray-700 shadow appearance-none border rounded w-full py-2 px-3 leading-tight focus:outline-none focus:shadow-outline";
    $classInvalid = "border border-red-500 text-red-500 placeholder-red-500 shadow appearance-none border rounded w-full py-2 px-3 leading-tight focus:outline-none focus:shadow-outline";

    function classOf(bool $validity) {
        return ($validity ? "border border-red-500 text-red-500 placeholder-red-500"
        : "text-gray-700")
        . " shadow appearance-none border rounded w-full py-2 px-3 leading-tight focus:outline-none focus:shadow-outline";
        }
@endphp

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>PCorner</title>
    @vite(['resources/js/app.js'])
</head>

<body>
    <main class="grid bg-slate-200 dark:bg-gray-700 min-h-screen">
        <div class="m-auto sm:w-96">
            <form class="bg-white shadow-md rounded px-8 pt-4 pb-8" method="POST" action="/register">
                @csrf
                <Image class="m-auto my-4 w-16 h-16 sm:w-24 sm:h-24" src="/img/register.png" alt="register icon" />
                <p class="text-center text-gray-700 text-lg font-bold">Register</p>
                <div class="mt-8"></div>
                <div class="grid gap-4">
                    <input class="{{ classOf(false) }}" name="name" id="name" type="text" placeholder="Name" />
                    <div>
                        <div class="flex items-center border @error("handle") ? border-red-500 @else border-gray-300 @enderror rounded-md">
                            <span class="pl-3 text-gray-400">@</span>
                            <input class="flex-1 p-2 border-none focus:outline-none" name="handle" id="handle" type="text" placeholder="Handle" value="{{ old("handle") }}" />
                        </div>
                    </div>
                    <div>
                        <input class="@error("email") {{ $classInvalid }} @else {{ $classValid }} @enderror" name="email" id="email" type="text" placeholder="Email" value="{{ old("email") }}" />
                    </div>
                        <input class="@error("password") {{ $classInvalid }} @else {{ $classValid }} @enderror" name="password" id="password" type="password" placeholder="Password" />
                        <input class="@error("password_confirmation") {{ $classInvalid }} @else {{ $classValid }} @enderror" name="password_confirmation" id="password_confirmation" type="password" placeholder="Confirm Password" />
                    <p class="mb-4">
                        Already have an account? <a href="/login" class="cursor-pointer text-blue-600 hover:underline hover:decoration-blue-400 hover:text-blue-400 transition transform">
                            login
                        </a>
                    </p>
                </div>
                <button
                    class="w-full bg-black hover:opacity-70 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline transform transition duration-150"
                    type="submit">
                    Submit
                </button>
            </form>
        </div>
    </main>
</body>

</html>
