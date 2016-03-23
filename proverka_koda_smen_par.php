<?php
session_start();
include('bd.php');
$imya_pol = $_GET['imya_pol'];
$el_pochta = $_GET['el_pochta'];
$kod = $_GET['kod'];

$bd_kod = mysql_fetch_array(mysql_query("SELECT `kod` FROM `tp` WHERE `el_p` = '".$el_pochta."'"));
$bd_kod = $bd_kod['kod'];

if ($bd_kod == $kod)
{
	$nov_par = mysql_fetch_array(mysql_query("SELECT `nov_par` FROM `tp` WHERE `el_p` = '".$el_pochta."'"));
	$nov_par = $nov_par['nov_par'];
	
	mysql_query("
	UPDATE `tp` SET `par`= '".$nov_par."' WHERE `el_p` = '".$el_pochta."'
	");
	
	mysql_query("UPDATE `tp` SET `kod` = NULL, `nov_par` = NULL WHERE `el_p` = '".$el_pochta."'");

	include('uspex_smen_par.html');
	}
		
mysql_close($podkluchenie);
?>