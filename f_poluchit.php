<?php //error_reporting(0);
session_start();

$massiv_itog = $_SESSION["massiv_itog"];
if (count($massiv_itog) < 12 )
{
	$oshibka_kolichestva = "<hr class=\"otbivka_0\"><span class=\"oshibka\">&#9998; В наборе менее 12-ти уникальных ключевых слов.</span>";
	//SESSION///////////////////////////////////////////////
	$_SESSION["oshibka_kolichestva"] = $oshibka_kolichestva;
	header("Location: http://200slov.andrej.by/shag_3.php");
	exit;
	}

$vr_nabora = time();
$ses = session_id();

include ('SQL_sozdat_nabor.php');

$_REZULTAT = implode("; ", $massiv_itog);
//SESSION///////////////////////////
$_SESSION["_REZULTAT"] = $_REZULTAT;

header("Location: http://200slov.andrej.by/shag_4.php");
?>