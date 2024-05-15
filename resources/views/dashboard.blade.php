<!DOCTYPE html>
<html class="h-full bg-white">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    @vite('resources/css/app.css')
</head>
<body class="h-full">
    <div class="flex min-h-full flex-col justify-center px-6 py-12 lg:px-8">
        <div class="sm:mx-auto sm:w-full sm:max-w-sm">
            <h1 class="text-3xl font-bold text-center mb-8">Dashboard</h1>
            <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
                <p class="text-center text-gray-700">¡Has iniciado sesión!</p>
            </div>
            <form action="/logout" method="POST">
                @csrf
                <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 px-4 rounded w-full">
                    Cerrar sesión
                </button>
            </form>
        </div>
    </div>
</body>
</html>
