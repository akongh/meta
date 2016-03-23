<?php //error_reporting(0);
session_start();

if(!isset($_SESSION["metka"]))
{
	header("Location: http://meta.afoteris.com/o_servise.php");
	}

$s_perevodom = $_SESSION["s_perevodom"];
$pro_zayavku = $_SESSION["pro_zayavku"];

include('shag_5.html');

unset($_SESSION["pro_zayavku"]);

//echo "<pre>";
//print_r(array_keys($_SESSION));
//echo "</pre>";
?>