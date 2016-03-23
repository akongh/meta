<?php
session_start();

include('metka_vxoda.php');

unset(
$_SESSION["SESSION_massiv_itog"], 
$_SESSION["massiv_rezultata"],
$_SESSION["kolichestvo_opornyx_slov"], 
$_POST["vvod_slov"], 
$_POST["slova_s_flagom"], 
$_POST["dopolnenie"]
);

header("Location: /1_vvod_slov.php");
?>