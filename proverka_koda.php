<?php
session_start();
include('bd.php');

$el_pochta = $_GET['el_pochta'];
$kod = $_GET['kod'];

$bd_kod = mysql_fetch_array(mysql_query("SELECT `kod` FROM `tp` WHERE `el_p` = '".$el_pochta."'"));
$bd_kod = $bd_kod['kod'];

if ($bd_kod == $kod)
{
	mysql_query("UPDATE `tp` SET `aktiv` = 1 WHERE `el_p` = '".$el_pochta."'");
	
	$idp = mysql_fetch_array(mysql_query("SELECT `idp` FROM `tp` WHERE `el_p` = '".$el_pochta."'"));
	$idp = $idp['idp'];
	
	mysql_query("
	CREATE TABLE `".$idp."--t_s`
	(
	`id_n` int(10) unsigned zerofill NOT NULL,
	`id_s` mediumint(8) unsigned zerofill NOT NULL
	)
	");
	
	mysql_query("UPDATE `tp` SET `kod` = NULL WHERE `el_p` = '".$el_pochta."'");

	include('uspex_reg.html');
	}
		
mysql_close($podkluchenie);
?>