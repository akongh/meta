<?php
session_start();

unset(
$_SESSION["vyvod_spiska_flagov"],
$_SESSION["dopolnitelnye_slova"],
$_SESSION["oshibka_nalichiya"],
$_SESSION["oshibka_simvola"],
$_SESSION["oshibka_kolichestva"],
$_SESSION["_MASSIV_rezultata"]
);

header("Location: http://proba.200slov.andrej.by");
?>