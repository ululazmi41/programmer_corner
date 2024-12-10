<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>PiCorner</title>
    @vite(['resources/js/app.js'])
</head>
<body>
    <x-navbar />
    <div class="px-4 sm:px-8 pb-4 pt-16">
        {{ $slot }}
    </div>
</body>
</html>