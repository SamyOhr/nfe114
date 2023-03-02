<?php

//C'est le POI de l'utilisateur
echo "lat\tlon\ttitle\tdescription\ticon\ticonSize\ticonOffset\n";
echo "43.296482\t5.36978\tMoi\tMa Position\tOl_icon_blue_example.png\t24,24\t0,-24\n";
echo "48.842053\t2.355763\tMusée d'Histoire Naturelle de Paris\tAdresse du Musée\tOl_icon_red_example.png\t24,24\t0,-24\n";


//1° - Connexion à la BDD
$base = new PDO('mysql:host=localhost; dbname=id20205701_samy', 'id20205701_samyouicher', '/&*hX18M$A}2#QGr');
$base->exec("SET CHARACTER SET utf8");

//2° - Préparation de requête et execution
$retour = $base->query('SELECT *, get_distance_metres(\'43.296482\', \'5.36978\', equi_lat, equi_long) 
AS proximite 
FROM equipement 
HAVING proximite < 1000 ORDER BY proximite ASC
LIMIT 10;
');

//Boucle For
while ($data = $retour->fetch()){
echo $data['equi_lat']."\t".$data['equi_long']."\t".$data['equi_nom']."\t".$data['equi_ad1']."\tOl_icon_red_example.png\t24,24\t0,-24\n";
}

?>
