<?php

// Connexion à la BDD
$base = new PDO('mysql:host=localhost; dbname=id20205701_samy', 'id20205701_samyouicher', '/&*hX18M$A}2#QGr');
$base->exec("SET CHARACTER SET utf8");

// Récupération des coordonnées de l'utilisateur
if (isset($_GET['lat']) && isset($_GET['lon'])) {
  $lat = $_GET['lat'];
  $lon = $_GET['lon'];
} else {
  // Si les coordonnées ne sont pas fournies, on utilise une position par défaut
  $lat = 43.296482;
  $lon = 5.36978;
}

// Préparation de requête et exécution
$retour = $base->query('SELECT *, get_distance_metres(:lat, :lon, equi_lat, equi_long) 
AS proximite 
FROM equipement 
HAVING proximite < 1000 ORDER BY proximite ASC
LIMIT 10;
');
$retour->bindParam(':lat', $lat);
$retour->bindParam(':lon', $lon);
$retour->execute();

// Affichage des POIs
echo "lat\tlon\ttitle\tdescription\ticon\ticonSize\ticonOffset\n";
while ($data = $retour->fetch()){
  echo $data['equi_lat']."\t".$data['equi_long']."\t".$data['equi_nom']."\t".$data['equi_ad1']."\tOl_icon_red_example.png\t24,24\t0,-24\n";
}

?>
