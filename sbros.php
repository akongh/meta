<?php
session_start();
unset(
$_SESSION["SESSION_massiv_itog"], 
$_SESSION["massiv_rezultata"],
$_SESSION["kolichestvo_opornyx_slov"], 
$_SESSION["vvod_slov_utochnit"],
$_POST["vvod_slov"], 
$_POST["slova_s_flagom"], 
$_POST["dopolnenie"]
);
header("Location: http://200slov.andrej.by");
?>