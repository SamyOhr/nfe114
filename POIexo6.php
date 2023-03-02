<?php
// Connexion à la BDD
$base = new PDO('mysql:host=localhost; dbname=id20205701_samy', 'id20205701_samyouicher', '/&*hX18M$A}2#QGr');
$base->exec("SET CHARACTER SET utf8");

// Récupération des équipements à moins de 1 km du POI initial
$retour = $base->query('SELECT *, get_distance_metres(\'43.296482\', \'5.36978\', equi_lat, equi_long) 
AS proximite 
FROM equipement 
HAVING proximite < 1000 ORDER BY proximite ASC
LIMIT 10;
');

// Boucle pour afficher les équipements sur la carte
while ($data = $retour->fetch()){
    echo "positionnerPOI(".$data['equi_long'].",".$data['equi_lat'].");\n";
}
?>

