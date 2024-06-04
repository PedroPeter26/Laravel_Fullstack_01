<!DOCTYPE html>
<html class="h-full bg-white">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <title>Mapa de Usuarios</title>
  @vite('resources/css/app.css')
</head>
<body class="h-full">
        <div class="flex justify-between">
            <a href="{{ route('dashboard') }}" class="text-indigo-600 hover:text-indigo-500">Regresar al Dashboard</a>
            <button type="submit" class="bg-indigo-600 px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 rounded-md">Guardar Cambios</button>
        </div>
  <div class="flex min-h-full flex-col justify-center px-6 py-12 lg:px-8">
    <div id="map" style="height: 400px;"></div>
  </div>

  <script>
    var map;
    var markers = [];

    function initMap() {
        map = new google.maps.Map(document.getElementById('map'), {
            center: {lat: 19.4326, lng: 99.1332},
            zoom: 9
        });

        var usuarios = JSON.parse('@json($users)');

        usuarios.forEach(function(usuario) {
            var latLng = new google.maps.LatLng(usuario.latitude, usuario.longitude);

            var marker = new google.maps.Marker({
                position: latLng,
                map: map,
                title: usuario.name
            });

            var infowindow = new google.maps.InfoWindow({
                content: '<strong>Ubicacion de: ' + usuario.name + '</strong>'
            });

            marker.addListener('click', function() {
                infowindow.open(map, marker);
            });

            markers.push(marker);
        });

        if (markers.length > 0) {
            var bounds = new google.maps.LatLngBounds();
            markers.forEach(function(marker) {
                bounds.extend(marker.getPosition());
            });
            map.fitBounds(bounds);
        }
    }
</script>

  <script async defer src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_API_KEY') }}&callback=initMap"></script>
</body>
</html>
