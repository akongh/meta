<?php
session_start();
require_once('bd.php');

if (isset($_POST["smen_zab_par_otprav"]))
{
	$smen_zab_par_el_pochta = trim(htmlspecialchars(stripslashes($_POST["smen_zab_par_el_pochta"])));
	$smen_zab_par_el_pochta = mysql_fetch_array(mysql_query("SELECT `el_p` FROM `tp` WHERE `el_p` = '".$smen_zab_par_el_pochta."'"));
	$el_pochta = $smen_zab_par_el_pochta['el_p'];

	if (!empty($el_pochta))
	{
		$nov_parol = rand(10000,30000);
		$nov_parol_md5 = md5($nov_parol);
		mysql_query("UPDATE `tp` SET `par` = '".$nov_parol_md5."' WHERE `el_p` = '".$el_pochta."'");

		$tema_pisma = "Новый пароль для входа на slova.sferagrafiki.ru";
		$tekst_pisma = "Вам назначен новый пароль: " . $nov_parol;
		require_once('pismo.php');
		
		require_once('smen_zab_par_otpravlen.html');
		}
		else
		{
			$oshibka_smen_zab_par_el_pocta = "<hr class=\"otbivka_0\"><span class=\"oshibka\">Такой адрес эл. почты не зарегистрирован.</span>";
			require_once('smen_zab_par.html');
			}
}

mysql_close($podkluchenie);
unset($oshibka_smen_zab_par_el_pocta);
?>