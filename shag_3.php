<?php error_reporting(0);
session_start();
if(!isset($_SESSION["metka"]))
{
	header("Location: http://meta.afoteris.com/o_servise.php");
	}

$sobranny_nabor = $_SESSION["sobranny_nabor"];

$oshibka_kolichestva = $_SESSION["oshibka_kolichestva"];

include( 'shag_3.html' );

//echo "<pre>";
//print_r(array_keys($_SESSION));
//echo "</pre>";
?>