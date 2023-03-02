<?php
//Récupération des coordonnées GPS choisies par l'utilisateur
if (isset($_POST['lat']) && isset($_POST['lon'])) {
  $lat = $_POST['lat'];
  $lon = $_POST['lon'];
} else {
  //Si les coordonnées n'ont pas encore été entrées, on initialise à un emplacement par défaut
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
    <form method="post">
      Latitude : <input type="text" name="lat" id="lat" value="<?php echo $lat; ?>">
      Longitude: <input type="text" name="lon" id="lon" value="<?php echo $lon; ?>">
      <input type="submit" value="Afficher">
    </form>
    <script>
      var map = new OpenLayers.Map("mapdiv");
      map.addLayer(new OpenLayers.Layer.OSM());

      //Créer un marqueur à l'emplacement choisi
      var lonLat = new OpenLayers.LonLat(<?php echo $lon; ?>, <?php echo $lat; ?>).transform(
        new OpenLayers.Projection("EPSG:4326"), // transform from WGS 1984
        map.getProjectionObject() // to Spherical Mercator Projection
      );
      var marker = new OpenLayers.Layer.Markers( "Markers" );
      marker.addMarker(new OpenLayers.Marker(lonLat));
      map.addLayer(marker);

      function updateMap() {
        var lat = document.getElementById("lat").value;
        var lon = document.getElementById("lon").value;
        var lonLat = new OpenLayers.LonLat(lon, lat).transform(
          new OpenLayers.Projection("EPSG:4326"), // transform from WGS 1984
          map.getProjectionObject() // to Spherical Mercator Projection
        );
        var zoom = 12;
        map.setCenter(lonLat, zoom);

        //Supprimer le marqueur existant
        map.removeLayer(marker);

        //Créer un nouveau marqueur à l'emplacement choisi
        marker = new OpenLayers.Layer.Markers( "Markers" );
        marker.addMarker(new OpenLayers.Marker(lonLat));
        map.addLayer(marker);
      }

      //Set start centrepoint and zoom
      map.setCenter(lonLat, 12);
    </script>
  </body>
</html>
