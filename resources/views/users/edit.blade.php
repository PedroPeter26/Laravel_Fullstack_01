<!DOCTYPE html>
<html class="h-full bg-white">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <title>Editar Usuario</title>
  @vite('resources/css/app.css')
</head>
<body class="h-full">
  <div class="flex min-h-full flex-col justify-center px-6 py-12 lg:px-8">
    <div class="sm:mx-auto sm:w-full sm:max-w-sm">
      <h1 class="text-3xl font-bold text-center mb-8">Editar Usuario</h1>
      <form class="space-y-6" action="{{ route('users.update', $user->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div>
          <label for="name" class="block text-sm font-medium leading-6 text-gray-900">Nombre</label>
          <div class="mt-2">
            <input id="name" name="name" type="text" value="{{ old('name', $user->name) }}" required class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
          </div>
        </div>

        <div>
          <label for="lastname_p" class="block text-sm font-medium leading-6 text-gray-900">Apellido Paterno</label>
          <div class="mt-2">
            <input id="lastname_p" name="lastname_p" type="text" value="{{ old('lastname_p', $user->lastname_p) }}" required class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
          </div>
        </div>

        <div>
          <label for="lastname_m" class="block text-sm font-medium leading-6 text-gray-900">Apellido Materno</label>
          <div class="mt-2">
            <input id="lastname_m" name="lastname_m" type="text" value="{{ old('lastname_m', $user->lastname_m) }}" required class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
          </div>
        </div>

        <div>
          <label for="age" class="block text-sm font-medium leading-6 text-gray-900">Edad</label>
          <div class="mt-2">
            <input id="age" name="age" type="number" value="{{ old('age', $user->age) }}" required class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
          </div>
        </div>

        <div>
          <label for="birthdate" class="block text-sm font-medium leading-6 text-gray-900">Fecha de Nacimiento</label>
          <div class="mt-2">
            <input id="birthdate" name="birthdate" type="date" value="{{ old('birthdate', $user->birthdate) }}" required class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
          </div>
        </div>

        <div>
          <label for="email" class="block text-sm font-medium leading-6 text-gray-900">Correo Electrónico</label>
          <div class="mt-2">
            <input id="email" name="email" type="email" value="{{ old('email', $user->email) }}" required class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
          </div>
        </div>

        <div>
          <label for="phone" class="block text-sm font-medium leading-6 text-gray-900">Teléfono</label>
          <div class="mt-2">
            <input id="phone" name="phone" type="tel" value="{{ old('phone', $user->phone) }}" required class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
          </div>
        </div>

        <div>
          <label for="latitude" class="block text-sm font-medium leading-6 text-gray-900">Latitud</label>
          <div class="mt-2">
            <input id="latitude" name="latitude" type="text" value="{{ old('latitude', $user->latitude) }}" required class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
          </div>
        </div>

        <div>
          <label for="longitude" class="block text-sm font-medium leading-6 text-gray-900">Longitud</label>
          <div class="mt-2">
            <input id="longitude" name="longitude" type="text" value="{{ old('longitude', $user->longitude) }}" required class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
          </div>
        </div>

        <div class="flex justify-between">
          <a href="{{ route('dashboard') }}" class="text-indigo-600 hover:text-indigo-500">Regresar al Dashboard</a>
          <button type="submit" class="bg-indigo-600 px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 rounded-md">Guardar Cambios</button>
        </div>
      </form>
    </div>

    <div id="map" style="height: 400px; margin-top: 20px;"></div>
  </div>

  <script type="text/javascript">
    $(document).ready(function(){
      var latitude = parseFloat($('#latitude').val());
      var longitude = parseFloat($('#longitude').val());

      if (!isNaN(latitude) && !isNaN(longitude)) {
        var userLatLng = { lat: latitude, lng: longitude };

        var map = new google.maps.Map(document.getElementById('map'), {
          zoom: 10,
          center: userLatLng
        });

        var marker = new google.maps.Marker({
          position: userLatLng,
          map: map,
          title: 'Ubicación del usuario'
        });
      }
    });
  </script>

  <script async defer src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_API_KEY') }}&callback=initMap"></script>
</body>
</html>
