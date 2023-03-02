<?php
  if(isset($_POST['lat']) && isset($_POST['lon'])) {
    $lat = $_POST['lat'];
    $lon = $_POST['lon'];
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
      Latitude : <input type="text" name="lat" id="lat" value="<?php echo $lat; ?>">
      Longitude: <input type="text" name="lon" id="lon" value="<?php echo $lon; ?>">
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
        var lat = document.getElementById("lat").value;
        var lon = document.getElementById("lon").value;
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

