<?php //error_reporting(0);
session_start();
if(!isset($_SESSION["metka"]))
{
	header("Location: http://200slov.andrej.by");
	}

$ochered = $_SESSION["ochered"];

$oshibka_kolichestva = $_SESSION["oshibka_kolichestva"];

include('shag_4.html');

//echo "<pre>";
//print_r(array_keys($_SESSION));
//echo "</pre>";
?>