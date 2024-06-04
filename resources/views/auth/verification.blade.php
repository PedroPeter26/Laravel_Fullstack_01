<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  @vite('resources/css/app.css')
  <title>Verificación de Correo Electrónico</title>
</head>
<body class="bg-gray-100 h-screen antialiased leading-none">
    <div class="flex justify-center items-center h-full">
        <div class="max-w-md w-full bg-white shadow-md rounded-lg p-8">
            <h1 class="text-2xl font-semibold text-gray-900 mb-6 text-center">Verificación de Correo Electrónico</h1>

            @if ($errors->any())
                <div class="mb-4">
                    <ul class="list-disc list-inside text-red-600">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('verification.verify') }}" method="POST">
                @csrf
                <input type="hidden" name="email" value="{{ request()->query('email') }}">
                <div class="mb-4">
                    <label for="verification_code" class="block text-gray-700 text-sm font-bold mb-2">Código de Verificación</label>
                    <input type="text" id="verification_code" name="verification_code" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                </div>

                <div class="flex items-center justify-between">
                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                        Verificar
                    </button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
