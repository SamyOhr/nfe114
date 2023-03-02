<?php
// Vérifiez que les variables lat et lon ont été passées dans la requête GET
if (isset($_GET['lat']) && isset($_GET['lon'])) {
  // Récupérez les coordonnées saisies par l'utilisateur
  $lat = $_GET['lat'];
  $lon = $_GET['lon'];

  // Affichez le marqueur pour la position de l'utilisateur
  echo $lat . "\t" . $lon . "\t" . "Ma position" . "\t" . "Je suis ici" . "\t" . "pngegg.png" . "\t24,24\t0,-24\n";

  // Connexion à la base de données et récupération des POI à proximité (comme avant)
  $base = new PDO('mysql:host=localhost; dbname=id20205701_samy', 'id20205701_samyouicher', '/&*hX18M$A}2#QGr');
  $base->exec("SET CHARACTER SET utf8");
  $retour = $base->query('SELECT *, get_distance_metres(\''.$lat.'\', \''.$lon.'\', equi_lat, equi_long) AS proximite FROM equipement HAVING proximite < 1000 ORDER BY proximite ASC LIMIT 10;');

  // Boucle pour afficher les POI
  while ($data = $retour->fetch()){
    echo $data['equi_lat'] . "\t" . $data['equi_long'] . "\t" . $data['equi_nom'] . "\t" . $data['equi_ad1'] . "\tOl_icon_red_example.png\t24,24\t0,-24\n";
  }
}
?>

