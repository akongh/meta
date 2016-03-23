<?php
session_start();

include('SQL_slova_nabory.php');

$vvod_slov = $_SESSION["vvod_slov"];
$oshibka_net_slov = $_SESSION["oshibka_net_slov"];
$oshibka_simvol = $_SESSION["oshibka_simvol"];

include('shag_1.html');
?>
