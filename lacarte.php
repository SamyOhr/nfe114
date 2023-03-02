<!DOCTYPE html>
<html>
  <head>
    <title>Ma carte</title>
  </head>
  <body>
    <form action="lacarte.php" method="post">
      <label for="latitude">Latitude :</label>
      <input type="text" id="latitude" name="latitude" placeholder="Entrez la latitude"><br>
      <label for="longitude">Longitude :</label>
      <input type="text" id="longitude" name="longitude" placeholder="Entrez la longitude"><br>
      <button type="submit">Afficher la carte</button>
    </form>

    <?php
      if(isset($_POST['latitude']) && isset($_POST['longitude'])){
        $latitude = $_POST['latitude'];
        $longitude = $_POST['longitude'];
    ?>

    <div id="mapdiv"></div>
    <script src="https://openlayers.org/api/OpenLayers.js"></script>
    <script>
      var latitude = <?php echo $latitude ?>;
      var longitude = <?php echo $longitude ?>;
      map = new OpenLayers.Map("mapdiv");
      map.addLayer(new OpenLayers.Layer.OSM());

      var pois = new OpenLayers.Layer.Text("My Points", {
        location: "./POI.php",
        projection: map.displayProjection,
      });
      map.addLayer(pois);

      var lonLat = new OpenLayers.LonLat(longitude, latitude).transform(
        new OpenLayers.Projection("EPSG:4326"), // transform from WGS 1984
        map.getProjectionObject() // to Spherical Mercator Projection
      );
      var zoom = 12;
      map.setCenter(lonLat, zoom);
    </script>

    <?php } ?>
  </body>
</html>
