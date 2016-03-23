<?php
session_start();

include('SQL_slova_nabory.php');

if(isset($_SESSION["kol_slov_itog"]))
{
	$kol_slov_itog = $_SESSION["kol_slov_itog"];
	}
	else
	{
		$kol_slov_itog = 0;
		}
$vvod_slov = $_SESSION["vvod_slov"];
$oshibka_net_slov = $_SESSION["oshibka_net_slov"];
$oshibka_simvol = $_SESSION["oshibka_simvol"];
$stroka_itog_zapom = $_SESSION["stroka_itog_zapom"];

include('shag_1.html');

//echo "Сессии <pre>";
//print_r($_SESSION);
//echo "</pre>";
?>
