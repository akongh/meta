<?php
session_start();

unset(
$_SESSION["kol_slov_itog"],
$_SESSION["massiv_itog"],
$_SESSION['dopolnenie_unikalnoe']
);

if(!isset($_SESSION["kol_slov_itog"]))
{
	$kol_slov_itog = 0;
	}

$vyvod_spiska = $_SESSION['vyvod_spiska'];
$dopolnenie_unikalnoe = $_SESSION['dopolnenie_unikalnoe'];

include('SQL_slova_nabory.php');

include ('shag_2.html');

?>