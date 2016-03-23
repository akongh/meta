<?php //error_reporting(0);
session_start();

$massiv_itog = $_POST["spisok_mesto"];

$massiv_itog_strokoj = implode("", $massiv_itog);

unset($_SESSION["oshibka_kolichestva"]);

$_SESSION["kol_slov_itog"] = count($massiv_itog);

$vr_nabora = time();
$ses = session_id();

if(!preg_match("/[a-z]+/i", $massiv_itog_strokoj))
{
	include ('SQL_sozdat_nabor_k.php');
	}
	else if (!preg_match("/[а-яё]+/i", $massiv_itog_strokoj))
	{
		include ('SQL_sozdat_nabor_l.php');
		}

$_REZULTAT = implode("; ", $massiv_itog);
//SESSION///////////////////////////
$_SESSION["_REZULTAT"] = $_REZULTAT;

header("Location: http://200slov.andrej.by/shag_5.php");
?>