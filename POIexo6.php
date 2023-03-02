<?php
  if(isset($_POST['rue']) && isset($_POST['code'])) {
    $rue = $_POST['rue'];
    $code = $_POST['code'];

    // appel à l'API de géocodage pour récupérer les coordonnées de l'adresse saisie
    $url = "https://api-adresse.data.gouv.fr/search/?q=".urlencode($rue)."&postcode=".urlencode($code);
    $json = file_get_contents($url);
    $data = json_decode($json, true);
    $lat = $data['features'][0]['geometry']['coordinates'][1];
    $lon = $data['features'][0]['geometry']['coordinates'][0];
  } else {
    $lat = 43.296482;
    $lon = 5.36978;
  }
?>

<html>
  <head>
    <script src="https://openlayers.org/api/OpenLayers.js"></script>
  </head>
  <body>
    <div id="mapdiv"></div>
    <form method="post" action="">
      Adresse : <input type="text" name="rue" id="rue">
      Code postal: <input type="text" name="code" id="code">
      <input type="submit" value="Afficher">
    </form>
    <script>
      var map = new OpenLayers.Map("mapdiv");
      map.addLayer(new OpenLayers.Layer.OSM());

      var markers = new OpenLayers.Layer.Markers( "Markers" );
      map.addLayer(markers);

      function addMarker(lonLat) {
        markers.clearMarkers();
        markers.addMarker(new OpenLayers.Marker(lonLat));
      }

      function updateMap() {
        var lat = <?php echo $lat; ?>;
        var lon = <?php echo $lon; ?>;
        var lonLat = new OpenLayers.LonLat(lon, lat).transform(
          new OpenLayers.Projection("EPSG:4326"), // transform from WGS 1984
          map.getProjectionObject() // to Spherical Mercator Projection
        );
        var zoom = 12;
        map.setCenter(lonLat, zoom);
        addMarker(lonLat);
      }

      //Set start centrepoint and zoom
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

