<html>
  <head>
    <script src="https://openlayers.org/api/OpenLayers.js"></script>
  </head>
  <body>
    <div id="mapdiv"></div>
    <form>
      Latitude : <input type="text" name="lat" id="lat">
      Longitude: <input type="text" name="lon" id="lon">
      <input type="button" value="Rechercher" onclick="updateMap()">
    </form>
    <script>
      var map = new OpenLayers.Map("mapdiv");
      map.addLayer(new OpenLayers.Layer.OSM());

      var pois = new OpenLayers.Layer.Text("My Points", {
        location: "./POI.php",
        projection: map.displayProjection,
      });
      map.addLayer(pois);

      function updateMap() {
        var lat = document.getElementById("lat").value;
        var lon = document.getElementById("lon").value;
        var lonLat = new OpenLayers.LonLat(lon, lat).transform(
          new OpenLayers.Projection("EPSG:4326"), // transform from WGS 1984
          map.getProjectionObject() // to Spherical Mercator Projection
        );
        var zoom = 12;
        map.setCenter(lonLat, zoom);

        //Add a marker for the user's position
        var userMarker = new OpenLayers.Marker(lonLat);
        map.addLayer(new OpenLayers.Layer.Markers("User Position")).addMarker(
          userMarker
        );
      }

      //Set start centrepoint and zoom
      var lonLat = new OpenLayers.LonLat(5.36978, 43.296482).transform(
        new OpenLayers.Projection("EPSG:4326"), // transform from WGS 1984
        map.getProjectionObject() // to Spherical Mercator Projection
      );
      var zoom = 12;
      map.setCenter(lonLat, zoom);
    </script>
  </body>
</html>
