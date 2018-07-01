<?php

$jour = date('d');
$mois = date('m');
$annee = date('Y');

$heure = date('H');
$minute = date('i');

echo 'Bonjour, nous somme le ' . $jour . '/' . $mois . '/' . $annee . ' et il est ' . $heure . ':' . $minute;

?>