<?php
  session_start();
  include('bd.php');
  
  $el_p_pol = $_SESSION["el_pochta_vxod"];
  $kod = md5(rand());
  mysql_query(" 
	  UPDATE `tp` SET `kod`='".$kod."' WHERE `el_p` = '".$el_p_pol."'
	  ");
  $imya = mysql_fetch_array(mysql_query("SELECT `imya` FROM `tp` WHERE `el_p` = '".$el_p_pol."'"));
  $imya = $imya['imya'];

  $tema_pisma = "=?utf-8?b?" . base64_encode("Повторная ссылка для регистрации на сайте 200slov.andrej.by") . "?=";
  $tekst_pisma = "Подтвердите регистрацию на сайте 200slov.andrej.by, перейдя по <a href=\"http://200slov.andrej.by/proverka_koda.php?el_pochta=" . $el_p_pol . "&kod=" . $kod . "\">этой ссылке</a>.";
  include('pismo.php');
  
  include ('reg_pismo_povtor.html');
?>