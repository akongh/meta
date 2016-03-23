<?php
session_start();
include('metka_vxoda.php');

$id_pol = $_SESSION['id_pol'];
$imya_pol = $_SESSION['imya_pol'];
$el_p_pol = $_SESSION['el_p_pol'];

if (isset($_POST["soobsshenie"]) && !empty($_POST["soobsshenie"]))
{
	$tema_pisma = "№".$id_pol.", ".$imya_pol.", ".$el_p_pol."";
	$tekst_pisma = trim(htmlspecialchars(strip_tags(stripslashes($_POST["soobsshenie"]))));
	include('pismo_soobsshenie.php');
	
	include('bd.php');
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

include('obratnaya_svyaz.html');
?>