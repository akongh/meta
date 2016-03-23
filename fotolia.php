<?php //error_reporting(0);
include ('/home/webart/www/d_meta/bd_meta.php');

$nomer_straniczy_zapros = mysql_query("SELECT `fotolia` FROM `tyrki` WHERE `f` = 1");
$nomer_straniczy_otvet = mysql_fetch_row($nomer_straniczy_zapros);
$nomer_straniczy = $nomer_straniczy_otvet[0] + 1;
$nomer_straniczy_2 = $nomer_straniczy + 10000;

include('tyrka_fotolia.html');
?>