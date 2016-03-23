<?php
session_start();
include('SQL_statistika.php');

$kir_kol_slov = $_SESSION["kir_kol_slov"];
$kir_kol_naborov = $_SESSION["kir_kol_naborov"];
$lat_kol_slov = $_SESSION["lat_kol_slov"];
$lat_kol_naborov = $_SESSION["lat_kol_naborov"];

include('shag_4.html');

echo "<pre>";
print_r(array_keys($_SESSION));
echo "</pre>";
?>