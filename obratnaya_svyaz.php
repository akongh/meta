<?php
session_start();
require_once('metka_vxoda.php');

$id_pol = $_SESSION['id_pol'];
$imya_pol = $_SESSION['imya_pol'];
$el_p_pol = $_SESSION['el_p_pol'];

if (isset($_POST["soobsshenie"]) && !empty($_POST["soobsshenie"]))
{
	$tema_pisma = "".$_SESSION['imya_pol'].", ".$_SESSION['el_p_pol'].", уч. запись №".$_SESSION['id_pol']."";
	$tekst_pisma = trim(htmlspecialchars(strip_tags(stripslashes($_POST["soobsshenie"]))));
	require_once('pismo_soobsshenie.php');
	
	require_once('bd.php');
	$vr_s = time();
	$soob = trim(htmlspecialchars(strip_tags(stripslashes($_POST["soobsshenie"]))));
	
	$vstav_soob = mysql_query("
	INSERT INTO `soob` (`el_p`, `vr_s`, `soob`)  
	VALUES ('".$el_p_pol."', '".$vr_s."', '".$soob."')
	");
	
	mysql_close($podkluchenie);
	
	unset($_POST["soobsshenie"]);
	header("Location: /soobssh_otpravleno.php");
	}

require_once('obratnaya_svyaz.html');
?>