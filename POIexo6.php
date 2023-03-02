<?php

// 1° - Connexion à la BDD
$base = new PDO('mysql:host=localhost; dbname=id20205701_samy', 'id20205701_samyouicher', '/&*hX18M$A}2#QGr');
$base->exec("SET CHARACTER SET utf8");

// 2° - Préparation de la requête et exécution pour récupérer les équipements proches de la position de l'utilisateur
$retour = $base->query('SELECT *, get_distance_metres(\''.$_GET['lat'].'\', \''.$_GET['lon'].'\', equi_lat, equi_long) 
AS proximite 
FROM equipement 
HAVING proximite < 1000 ORDER BY proximite ASC
LIMIT 10;
');

// Définition des colonnes pour les points d'intérêts (POI)
echo "lat\tlon\ttitle\tdescription\ticon\ticonSize\ticonOffset\n";

// Récupération des données pour le POI de l'utilisateur
echo $_GET['lat']."\t".$_GET['lon']."\tMoi\tMa Position\tOl_icon_blue_example.png\t24,24\t0,-24\n";

// Boucle pour afficher les équipements proches
while ($data = $retour->fetch()){
    echo $data['equi_lat']."\t".$data['equi_long']."\t".$data['equi_nom']."\t".$data['equi_ad1']."\tOl_icon_red_example.png\t24,24\t0,-24\n";
}

?>
