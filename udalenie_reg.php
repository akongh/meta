<?php
session_start();
require_once ('metka_vxoda.php');
$id_pol = $_SESSION['id_pol'];
$imya_pol = $_SESSION['imya_pol'];
$el_p_pol = $_SESSION['el_p_pol'];

if($_POST['udal_reg_2'])
{
	require_once ('bd.php');
	mysql_query("DROP TABLE `".$id_pol."--tn`, `".$id_pol."--t_s`");
	mysql_query("DELETE FROM `tp` WHERE `idp` = '".$id_pol."'");
	
	$tema_pisma = "Удаление регистрации со slova2.sferagrafiki.ru";
	$tekst_pisma = "Ваша регистрация успешно удалена.";
	//$dop_zagolovok = 'MIME-Version: 1.0' . "\r\n" . 'Content-Type: text/html; charset=utf-8' . "\r\n";
	$dop_zagolovok = 'From: slova.by <admin@andrej.by>' . "\r\n" . 'X-Mailer: PHP/' . phpversion();
	mail($el_p_pol, $tema_pisma, $tekst_pisma, $dop_zagolovok); //здесь письмо отправить
	
	require_once("udalenie_reg.html");
	mysql_close($podkluchenie);
	session_destroy();
	}
	
if($_POST['udal_reg_1'])
{
	require_once("podtv_udalenie_reg.html");
	}
?>