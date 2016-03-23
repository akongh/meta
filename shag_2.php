<?php //error_reporting(0);
session_start();
include('SQL_statistika.php');

$kir_kol_slov = $_SESSION["kir_kol_slov"];
$kir_kol_naborov = $_SESSION["kir_kol_naborov"];
$lat_kol_slov = $_SESSION["lat_kol_slov"];
$lat_kol_naborov = $_SESSION["lat_kol_naborov"];

$vyvod_spiska_flagov = $_SESSION["vyvod_spiska_flagov"];

$dopolnitelnye_slova = $_SESSION["dopolnitelnye_slova"];

$oshibka_simvola = $_SESSION["oshibka_simvola"];

$sostoyanie_nabora = $_SESSION["sostoyanie_nabora"];

include('shag_2.html');

//echo "<pre>";
//print_r(array_keys($_SESSION));
//echo "</pre>";
?>