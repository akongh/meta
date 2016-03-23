<?php //error_reporting(0);
session_start();
if(!isset($_SESSION["metka"]))
{
	header("Location: http://200slov.andrej.by");
	}

$s_perevodom = $_SESSION["s_perevodom"];

include('shag_5.html');

//echo "<pre>";
//print_r(array_keys($_SESSION));
//echo "</pre>";
?>