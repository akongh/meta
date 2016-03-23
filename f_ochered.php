<?php //error_reporting(0);
session_start();

//$massiv_itog = $_SESSION["massiv_itog"];

$massiv_itog = $_POST["massiv_itog"];

if (count($massiv_itog) < 12 )
{
	$oshibka_kolichestva = "<hr class=\"otbivka_0\"><span class=\"oshibka\">&#9998; В наборе менее 12-ти уникальных ключевых слов.</span>";
	//SESSION///////////////////////////////////////////////
	$_SESSION["oshibka_kolichestva"] = $oshibka_kolichestva;
	header("Location: http://200slov.andrej.by/shag_3.php");
	exit;
	}
	
$_SESSION["kol_slov_itog"] = count($_POST["massiv_itog"]);

for ($i = 0; $i < count($massiv_itog); $i++)
{
	$ochered[$i] = "<li><input type=\"checkbox\" name=\"spisok_mesto[]\" checked value = '".$massiv_itog[$i]."' hidden=\"true\">".$massiv_itog[$i]."</li>";
	}
	
$ochered = implode("", $ochered) . "<hr class=\"otbivka_24\">
<div class=\"statistika\">Слов в наборе — <span class=\"statistika_czyfra\">" . $_SESSION["kol_slov_itog"] . "</span>.</div>";

$_SESSION["ochered"] = $ochered;

header("Location: http://200slov.andrej.by/shag_4.php");
?>