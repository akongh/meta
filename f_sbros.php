<?php
session_start();
unset(
$_SESSION["vyvod_spiska"],
$_SESSION["stroka_itog_zapom"],
$_SESSION["dopolnenie_unikalnoe"],
$_SESSION["oshibka_simvol"],
$_SESSION["oshibka_net_slov"],
$_SESSION["vvod_slov"],
$_SESSION["kol_slov_itog"],
$_SESSION["stroka_itog"],
$_SESSION["massiv_itog"],
$_SESSION["massiv_itog_zapom"],
$_SESSION["massiv_rezultata"],
$_SESSION["kolichestvo_opornyx_slov"], 
$_SESSION["vvod_slov_utochnit"],
$_POST["vvod_slov"], 
$_POST["slova_s_flagom"], 
$_POST["dopolnenie"]
);
header("Location: http://200slov.andrej.by");

?>