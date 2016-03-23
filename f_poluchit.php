<?php //error_reporting(0);
session_start();

if (isset($_POST["spisok_mesto"]))
{
	$massiv_itog = $_POST["spisok_mesto"];
	if (count($massiv_itog) < 12 )
	{
		$oshibka_kolichestva = "<hr class=\"otbivka_0\"><span class=\"oshibka\">&#9998; В наборе менее 12-ти уникальных ключевых слов.</span>";
		//SESSION///////////////////////////////////////////////
		$_SESSION["oshibka_kolichestva"] = $oshibka_kolichestva;
		header("Location: http://proba.200slov.andrej.by/shag_4.php");
		exit;
		}
	}

unset($_SESSION["oshibka_kolichestva"]);

$_SESSION["kol_slov_itog"] = count($massiv_itog);

$vr_nabora = time();
$ses = session_id();

include ('SQL_sozdat_nabor.php');

$_REZULTAT = implode("; ", $massiv_itog);
//SESSION///////////////////////////
$_SESSION["_REZULTAT"] = $_REZULTAT;

header("Location: http://proba.200slov.andrej.by/shag_5.php");
?>