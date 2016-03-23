<?php //error_reporting(0);
session_start();
include('SQL_statistika.php');

$kir_kol_slov = $_SESSION["kir_kol_slov"];
$kir_kol_naborov = $_SESSION["kir_kol_naborov"];
$lat_kol_slov = $_SESSION["lat_kol_slov"];
$lat_kol_naborov = $_SESSION["lat_kol_naborov"];

$sobranny_nabor = $_SESSION["sobranny_nabor"] . "<hr class=\"otbivka_24\">
<div class=\"statistika\">Слов в наборе — <span class=\"statistika_czyfra\">" . $_SESSION["kol_slov_itog"] . "</span>.</div>";

$oshibka_kolichestva = $_SESSION["oshibka_kolichestva"];

include('shag_3.html');

//echo "<pre>";
//print_r(array_keys($_SESSION));
//echo "</pre>";
?>