<?php
require_once('bd.php');

if (isset($_POST["vosst_par_otprav"]))
{
	$vosst_par_el_pochta = trim(htmlspecialchars(stripslashes($_POST["vosst_par_el_pochta"])));
	
	$vosst_par_el_pochta_2 = mysql_query("SELECT `el_p` FROM `tp` WHERE `el_p` = '$vosst_par_el_pochta'");
	$vosst_par_el_pochta_2 = mysql_fetch_array($vosst_par_el_pochta_2);

	if (!empty($vosst_par_el_pochta_2['el_p']))
	{
		$nov_parol = rand(10000,30000);
		$nov_parol_md5 = md5($nov_parol);
		mysql_query("UPDATE `tp` SET `par` = '$nov_parol_md5' WHERE `el_p` = '$vosst_par_el_pochta'");
		
		
		$tema_pisma = "Новый пароль для входа на slova.sferagrafiki.ru";
		$tekst_pisma = "Вам назначен новый пароль: " . $nov_parol;
		$dop_zagolovok = 'MIME-Version: 1.0' . "\r\n" . 'Content-Type: text/html; charset=utf-8' . "\r\n";
		$dop_zagolovok = 'From: slova.by <admin@andrej.by>' . "\r\n" . 'X-Mailer: PHP/' . phpversion();
		mail($vosst_par_el_pochta, $tema_pisma, $tekst_pisma, $dop_zagolovok);//здесь письмо отправить
		
		require_once('vosst_par_otpravlen.html');
		}
		else
		{
			$oshibka_vosst_par_el_pocta = "<hr class=\"otbivka_0\"><span class=\"oshibka\">Такой адрес эл. почты не зарегистрирован.</span>";
			require_once('_vosst_par.html');
			}
}
mysql_close($podkluchenie);

unset($oshibka_vosst_par_el_pocta);
?>
