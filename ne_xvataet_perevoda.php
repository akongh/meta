<?php //error_reporting(0);
session_start();
if(!isset($_SESSION["metka"]))
{
	header("Location: http://200slov.andrej.by");
	}

include('ne_xvataet_perevoda.html');

//echo "<pre>";
//print_r(array_keys($_SESSION));
//echo "</pre>";
?>