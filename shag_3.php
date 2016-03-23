<?php //error_reporting(0);
session_start();
if(!isset($_SESSION["metka"]))
{
	header("Location: http://200slov.andrej.by");
	}

$sobranny_nabor = $_SESSION["sobranny_nabor"] . "<hr class=\"otbivka_24\">
<div class=\"statistika\">Ключевых слов в наборе — <span class=\"statistika_czyfra\">" . $_SESSION["kol_slov_itog"] . "</span>.</div>";

$oshibka_kolichestva = $_SESSION["oshibka_kolichestva"];

include('shag_3.html');

//echo "<pre>";
//print_r(array_keys($_SESSION));
//echo "</pre>";
?>