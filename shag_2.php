<?php //error_reporting(0);
session_start();
if(!isset($_SESSION["metka"]))
{
	header("Location: http://meta.afoteris.com/o_servise.php");
	}

$vyvod_spiska_flagov = $_SESSION["vyvod_spiska_flagov"];

$dopolnitelnye_slova = $_SESSION["dopolnitelnye_slova"];

$oshibka_simvola = $_SESSION["oshibka_simvola"];

$sostoyanie_nabora = $_SESSION["sostoyanie_nabora"];

include('shag_2.html');

//echo "<pre>";
//print_r(array_keys($_SESSION));
//echo "</pre>";
?>