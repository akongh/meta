<?php
session_start();

include('SQL_slova_nabory.php');

$vyvod_spiska = $_SESSION["vyvod_spiska"];
$oshibka_massiv_itog_10 = $_SESSION["oshibka_massiv_itog_10"];
$oshibka_simvol = $_SESSION["oshibka_simvol"];
$dopolnenie_unikalnoe = $_SESSION['dopolnenie_unikalnoe'];

include('shag_2.html');

unset
(
$_SESSION["oshibka_massiv_itog_10"],
$_SESSION["oshibka_simvol"]
);
?>