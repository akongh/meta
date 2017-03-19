<?php //error_reporting(0);
session_start();
include('SQL_statistika.php');

$kir_kol_slov = $_SESSION["kir_kol_slov"];
$kir_kol_naborov = $_SESSION["kir_kol_naborov"];
$lat_kol_slov = $_SESSION["lat_kol_slov"];
$lat_kol_naborov = $_SESSION["lat_kol_naborov"];

$opornye_slova = $_SESSION["opornye_slova"];

$oshibka_simvola = $_SESSION["oshibka_simvola"];

$sostoyanie_nabora = $_SESSION["sostoyanie_nabora"];

$obnovlenie_chastoty = $_SESSION["obnovlenie_chastoty"];

include('upravlyalka.html');

//echo "<pre>";
//print_r(array_keys($_SESSION));
//echo "</pre>";
//phpinfo();
?>