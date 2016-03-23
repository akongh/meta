<?php
session_start();

include ('bd.php');
$vr_nabora = time();
$ses = session_id();
$massiv_itog = $_SESSION["massiv_itog"];

if ($massiv_itog)
{
	include ('SQL_sozdat_nabor.php');
	}
mysql_close($podkluchenie);

unset(
$_SESSION["stroka_itog"],
$_SESSION["massiv_rezultata"],
$_SESSION["stroka_itog_zapom"],
$_SESSION["massiv_itog_zapom"],
$_SESSION["kol_slov_itog"],
$_SESSION["massiv_itog"],
$_SESSION["vvod_slov_utochnit"],
$_SESSION['vyvod_spiska'],
$_SESSION['dopolnenie_unikalnoe']
);
header("Location: http://proba.200slov.andrej.by");

//echo "Сессии <pre>";
//print_r($_SESSION);
//echo "</pre>";
?>