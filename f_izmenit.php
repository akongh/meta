<?php
session_start();

unset(
$_SESSION["oshibka_nalichiya"],
$_SESSION["oshibka_simvola"],
$_SESSION["oshibka_kolichestva"],
$_SESSION["sobranny_nabor"],
$_SESSION["massiv_itog"]
);

header("Location: http://proba.200slov.andrej.by/shag_2.php");
?>