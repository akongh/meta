<?php
//if($_SERVER['PHP_SELF'] != "/index.php")
//{
//	header("Location: http://200slov.andrej.by");
//	}
session_start();
//var_dump($_SESSION["massiv_itog_zapom"]);
//echo "<br>";
//var_dump($_SESSION["massiv_itog"]);

include('SQL_slova_nabory.php');

if(isset($_SESSION["kol_slov_itog"]))
{
	$kol_slov_itog = $_SESSION["kol_slov_itog"];
	}
	else
	{
		$kol_slov_itog = 0;
		}
$vyvod_spiska = $_SESSION["vyvod_spiska"];
$oshibka_massiv_itog_10 = $_SESSION["oshibka_massiv_itog_10"];
$oshibka_simvol = $_SESSION["oshibka_simvol"];
$dopolnenie_unikalnoe = $_SESSION['dopolnenie_unikalnoe'];
$stroka_itog_zapom = $_SESSION["stroka_itog_zapom"];

include('shag_2.html');

unset
(
$_SESSION["oshibka_massiv_itog_10"],
$_SESSION["oshibka_simvol"]
);
?>