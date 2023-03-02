<?php
  //Récupération des valeurs saisies par l'utilisateur
  $rue = $_POST['rue'] ?? '';
  $code = $_POST['code'] ?? '';
  
  //API issu de https://adresse.data.gouv.fr/api-doc/adresse
  $url = 'https://api-adresse.data.gouv.fr/search/?q=' . urlencode($rue) . '&postcode=' . urlencode($code);
  $json = file_get_contents($url);
  $data = json_decode($json);
  
  //Récupération des coordonnées GPS de l'adresse
  $lat = $data->features[0]->geometry->coordinates[1] ?? 43.296482;
  $lon = $data->features[0]->geometry->coordinates[0] ?? 5.36978;
?>

<html>
  <head>
    <script src="https://openlayers.org/api/OpenLayers.js"></script>
  </head>
  <body>
    <div id="mapdiv"></div>
    <script>
      var map = new OpenLayers.Map("mapdiv");
      map.addLayer(new OpenLayers.Layer.OSM());

      var markers = new OpenLayers.Layer.Markers( "Markers" );
      map.addLayer(markers);

      function addMarker(lonLat) {
        markers.clearMarkers();
        markers.addMarker(new OpenLayers.Marker(lonLat));
      }

      //Transforme les coordonnées GPS de l'utilisateur en Spherical Mercator Projection
      var lonLat = new OpenLayers.LonLat(<?php echo $lon; ?>, <?php echo $lat; ?>).transform(
        new OpenLayers.Projection("EPSG:4326"), // transform from WGS 1984
        map.getProjectionObject() // to Spherical Mercator Projection
      );
      var zoom = 12;
      map.setCenter(lonLat, zoom);
      addMarker(lonLat);
    </script>
  </body>
</html>
