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
                <h2 class="text-lg font-bold">Profiles</h2>
                <div class="grid gap-4 mt-4">
                    @foreach ($users as $user)
                        <div>
                            <p class="font-bold">{{ $user->name }}</p>
                            <p>email: {{ $user->email }}</p>
                            <p>username: {{ $user->username }}</p>
                        </div>
                    @endforeach
                </div>
            </form>
        </div>
    </main>
</body>

</html>
