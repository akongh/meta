<?php //error_reporting(0);
include ('/home/webart/www/_z/bd.php');

$nomer_straniczy_zapros = mysql_query("SELECT `lori` FROM `tyrki` WHERE `f` = 1");
$nomer_straniczy_otvet = mysql_fetch_row($nomer_straniczy_zapros);
$nomer_straniczy = $nomer_straniczy_otvet[0] + 1;
$nomer_straniczy_2 = $nomer_straniczy + 9999;

include('tyrka_lori.html');
?>