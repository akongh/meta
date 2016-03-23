<?php
  session_start();
  require_once('bd.php');
  
  $el_pochta = $_SESSION["el_pochta_vxod"];
  $kod = md5(rand());
  mysql_query(" 
	  UPDATE `tp` SET `kod`='".$kod."' WHERE `el_p` = '".$el_pochta."'
	  ");
  $imya = mysql_fetch_array(mysql_query("SELECT `imya` FROM `tp` WHERE `el_p` = '".$el_pochta."'"));
  $imya = $imya['imya'];

  $tema_pisma = "Повторная ссылка для регистрации на slova2.sferagrafiki.ru";
  $tekst_pisma = "Подтвердите регистрацию, перейдя по ссылке:\n 
  http://slova2.sferagrafiki.ru/proverka_koda.php?el_pochta=" . $el_pochta . "&kod=" . $kod;
  require_once('pismo.php');
  
  require_once ('reg_pismo_povtor.html');
?>