<?php //error_reporting(0);
session_start();

if (isset($_POST["opornoe_slovo_zayavki"]))
{
	$opornoe_slovo_zayavki = $_POST["opornoe_slovo_zayavki"];
	unset($_POST["opornoe_slovo_zayavki"]);
	$opornoe_slovo_zayavki = trim(mb_strtolower(htmlspecialchars(strip_tags(stripslashes($opornoe_slovo_zayavki))), "utf-8"));
	$opornoe_slovo_zayavki = preg_replace("/ {2,}/", " ", $opornoe_slovo_zayavki);
	$opornoe_slovo_zayavki = preg_replace("/-{2,}/", "-", $opornoe_slovo_zayavki);
	
	include ('/home/webart/www/_200slov.andrej.by/bd.php');
	
	$zayavka_na_perevod = "
	INSERT IGNORE INTO `zp` (`op`)
	VALUES ('" . $opornoe_slovo_zayavki . "')
	";
	mysql_query($zayavka_na_perevod);
	
	mysql_close($podkluchenie);
	}

include('zayavka_otpravlena.html');
//include('shag_0.html');

//echo "<pre>";
//print_r(array_keys($_SESSION));
//echo "</pre>";
?>