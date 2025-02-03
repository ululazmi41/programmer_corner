@php
    function getClass(String $name, $errors): String {
        $classValid = "text-gray-700 shadow appearance-none border rounded w-full py-2 px-3 leading-tight focus:outline-none focus:shadow-outline";
        $classInvalid = "border border-red-500 text-red-500 placeholder-red-500 shadow appearance-none border rounded w-full py-2 px-3 leading-tight focus:outline-none focus:shadow-outline";
        
        if (!empty($errors) && $errors->has($name)) {
            return $classInvalid;
        }
        return $classValid;
    }
@endphp

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login | PCorner</title>
    @vite(['resources/js/app.js'])
</head>

<body>
    <main class="grid bg-slate-200 dark:bg-gray-700 min-h-screen">
        <div class="m-auto sm:w-96">
            <form class="bg-white shadow-md rounded px-8 pt-4 pb-8" method="POST" action="/login">
                @csrf
                <Image class="m-auto my-4 w-16 h-16 sm:w-24 sm:h-24" src="/img/login.png" alt="login icon" />
                <p class="text-center text-gray-700 text-lg font-bold">Login</p>
                <div class="mt-8"></div>
                <div class="grid gap-4">
                    @error('login')
                        <p class="text-red-500 text-md m-0">{{ $message }}</p>
                    @enderror
                    <input class="{{ getClass('email', $errors) }}" name="email" id="email" type="text" placeholder="Username or email" value="{{ old("email") }}" />
                    <input class="{{ getClass('password', $errors) }}" name="password" id="password" type="password" placeholder="Password" />
                    <div class="mb-4">
                        <p>
                            Don't have an account? <a href="/register" class="cursor-pointer text-blue-600 hover:underline hover:decoration-blue-400 hover:text-blue-400 transition transform">
                                register
                            </a>
                        </p>
                        <a href="/dev/profiles" class="cursor-pointer text-blue-600 hover:underline hover:decoration-blue-400 hover:text-blue-400 transition transform">
                            profiles
                        </a>
                    </div>
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
