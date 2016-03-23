<?php
session_start();
include ('metka_vxoda.php');
$id_pol = $_SESSION['id_pol'];
$imya_pol = $_SESSION['imya_pol'];
$el_pochta = $_SESSION['el_p_pol'];

if($_POST['udal_reg_1'])
{
	include("podtv_udalenie_reg.html");
	}
	
if($_POST['udal_reg_2'])
{
	include ('bd.php');
	mysql_query("DROP TABLE `".$id_pol."--t_s`");
	mysql_query("DELETE FROM `tp` WHERE `idp` = '".$id_pol."'");
	
	$tema_pisma = "=?utf-8?b?" . base64_encode("Удаление регистрации с сайта 200slov.andrej.by") . "?=";
	$tekst_pisma = "Ваша регистрация на сайте 200slov.andrej.by успешно удалена.";
	include('pismo.php');
	
	include("udalenie_reg.html");
	mysql_close($podkluchenie);
	session_destroy();
	}
?>