<?php
session_start();
include ('metka_vxoda.php');
$id_pol = $_SESSION['id_pol'];
$imya_pol = $_SESSION['imya_pol'];

if($_POST['udal_nab_1'])
{
	include("podtv_udalenie_nab.html");
	}
	
if($_POST['udal_nab_2'])
{
	include ('bd.php');
	mysql_query("TRUNCATE TABLE `".$id_pol."--t_s`");
	mysql_close($podkluchenie);
	
	include("udalenie_nab.html");
	}
?>