<?php
  session_start();
  require_once('bd.php');
  
  $el_pochta = $_SESSION["el_pochta_vxod"];
  $kod = md5(rand());
  mysql_query(" 
	  UPDATE `tp` SET `kod`='" . $kod . "' WHERE `el_p` = '" . $el_pochta . "'
	  ");
  $imya = mysql_query("SELECT `imya` FROM `tp` WHERE `el_p` = '$el_pochta'");
  $otvet_imya = mysql_fetch_array($imya);
  $imya = $otvet_imya['imya'];

  $tema_pisma = "Повторная ссылка для регистрации на slova.sferagrafiki.ru";
  $tekst_pisma = "Подтвердите регистрацию, перейдя по ссылке:\n 
  http://slova.sferagrafiki.ru/proverka_koda.php?el_pochta=" . $el_pochta . "&kod=" . $kod;
  $dop_zagolovok = 'MIME-Version: 1.0' . "\r\n" . 'Content-Type: text/html; charset=utf-8' . "\r\n";
  $dop_zagolovok = 'From: slova.by <admin@andrej.by>' . "\r\n" . 'X-Mailer: PHP/' . phpversion();
  mail($el_pochta, $tema_pisma, $tekst_pisma, $dop_zagolovok); //здесь письмо отправить
  
  require_once ('_reg_pismo_povtor.html');
?>