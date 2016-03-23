<?php
session_start();
include ('metka_vxoda.php');
$id_pol = $_SESSION['id_pol'];
$imya_pol = $_SESSION['imya_pol'];
$el_p_pol = $_SESSION['el_p_pol'];//var_dump($el_p_pol);

include ('regularnye_vyrazheniya.php');
include ('slova_nabory_pol.php');

$parol = trim(htmlspecialchars(strip_tags(stripslashes($_POST["nov_parol"]))));
$parol_2 = trim(htmlspecialchars(strip_tags(stripslashes($_POST["nov_parol_2"]))));
if (empty($parol)) {
	$pusto_parol = "<hr class=\"otbivka_0\"><span class=\"oshibka\">Введите новый пароль.</span>";
} else {
	if (!preg_match($regulyar_parol, $parol)) {
		$oshibka_parol = "<hr class=\"otbivka_0\"><span class=\"oshibka\">Только цифры (5—12).</span>";
	} else {
		unset($$oshibka_parol);
	}
}
if (empty($parol_2)) {
	$pusto_parol_2 = "<hr class=\"otbivka_0\"><span class=\"oshibka\">Повторите новый пароль.</span>";
} else {
	if (!preg_match($regulyar_parol, $parol_2)) {
		$oshibka_parol_2 = "<hr class=\"otbivka_0\"><span class=\"oshibka\">Только цифры (5—12).</span>";
	} else {
		unset($$oshibka_parol_2);
	}
}
if ((!empty($parol) && !empty($parol_2)) && ($parol != $parol_2)) {
	$oshibka_raznye_paroli = "<hr class=\"otbivka_0\"><span class=\"oshibka\">Пароли не совпадают.</span>";
} else {
	unset($oshibka_raznye_paroli);
}
if ($oshibka_parol or $oshibka_parol_2 or $oshibka_raznye_paroli or $pusto_parol or $pusto_parol_2) {
	include ('kabinet.html');
} else {
	include ('bd.php');
	$kod = md5(rand());
	$parol = md5($parol);
	mysql_query("  
	UPDATE `tp` SET `nov_par` = '" . $parol . "', `kod` = '" . $kod . "'
	WHERE `el_p` = '" . $el_p_pol . "'
	");
	mysql_close($podkluchenie);
	$tema_pisma = "=?utf-8?b?" . base64_encode("Смена пароля на сайте 200slov.andrej.by") . "?=";
	$tekst_pisma = "Подтвердите смену пароля на сайте 200slov.andrej.by, перейдя по <a href=\"http://200slov.andrej.by/proverka_koda_smen_par.php?el_pochta=" . $el_p_pol . "&kod=" . $kod . "&imya_pol=" . $imya_pol . "\">этой ссылке</a>.";
	include('pismo.php');
	include ('smen_par_pismo.html');
}
?>