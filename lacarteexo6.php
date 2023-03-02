<html>
  <body>
    <div id="mapdiv"></div>
    <script src="https://openlayers.org/api/OpenLayers.js"></script>
    <script>
      var map, pois;

      function initMap() {
        map = new OpenLayers.Map("mapdiv");
        map.addLayer(new OpenLayers.Layer.OSM());

        pois = new OpenLayers.Layer.Text("My Points", {
          location: "./POIexo6.php",
          projection: map.displayProjection,
        });
        map.addLayer(pois);

        var lonLat = new OpenLayers.LonLat(0, 0).transform(
          new OpenLayers.Projection("EPSG:4326"),
          map.getProjectionObject()
        );
        var zoom = 2;
        map.setCenter(lonLat, zoom);
      }

      function updatePOI() {
        var rue = document.getElementById("rue").value;
        var ville = document.getElementById("code").value;

        var req = new XMLHttpRequest();
        req.open(
          "GET",
          "https://api-adresse.data.gouv.fr/search/?q=" + rue + "&postcode=" + ville,
          false
        );
        req.send(null);

        var geocodeObjet = JSON.parse(req.responseText);
        var long = geocodeObjet.features[0].geometry.coordinates[0];
        var lat = geocodeObjet.features[0].geometry.coordinates[1];

        var poi = pois.features[0];
        poi.geometry.x = long;
        poi.geometry.y = lat;
        poi.layer.drawFeature(poi);
        map.setCenter(new OpenLayers.LonLat(long, lat).transform(
          new OpenLayers.Projection("EPSG:4326"),
          map.getProjectionObject()
        ));
      }
    </script>

    <p>Adresse <input id="rue" /></p>
    <p>Code postal <input id="code" /></p>
    <button onclick="updatePOI()">Mettre à jour</button>

    <script>
      initMap();
    </script>
  </body>
</html>

