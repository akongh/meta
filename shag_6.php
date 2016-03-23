<?php //error_reporting(0);
session_start();
if(!isset($_SESSION["metka"]))
{
	header("Location: http://meta.afoteris.com/o_servise.php");
	}

$kol_slov_russk = $_SESSION["kol_slov_russk"];
$kol_slov_angl = $_SESSION["kol_slov_angl"];

$_REZULTAT_russk = $_SESSION["_REZULTAT_russk"];
$_REZULTAT_angl = $_SESSION["_REZULTAT_angl"];

if(isset($_SESSION["_REZULTAT_russk_neperevedennye"]))
{
	$_REZULTAT_russk_neperevedennye = $_SESSION["_REZULTAT_russk_neperevedennye"];
	}

$_REZULTAT_russk = $_REZULTAT_russk . "<hr class=\"otbivka_24\">
<div class=\"statistika\">Ключевых слов в наборе — <span class=\"statistika_czyfra\">" . $kol_slov_russk . "</span>.</div>";
$_REZULTAT_angl = $_REZULTAT_angl . "<hr class=\"otbivka_24\">
<div class=\"statistika\">Ключевых слов в наборе — <span class=\"statistika_czyfra\">" . $kol_slov_angl . "</span>.</div>";

include('shag_6.html');

//echo "<pre>";
//print_r(array_keys($_SESSION));
//echo "</pre>";
?>