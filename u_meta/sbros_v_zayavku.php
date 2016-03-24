<?php //error_reporting(0);
session_start();

include ('/home/webart/www/d_meta/bd_meta.php');

$na_zayavke_zapros = mysql_query("SELECT COUNT(*) FROM `k-ts` WHERE `f` = '7'");
$na_zayavke_otvet = mysql_fetch_row($na_zayavke_zapros);
$na_zayavke = $na_zayavke_otvet[0];

$perevedeno_zapros = mysql_query("SELECT COUNT(*) FROM `k-ts` WHERE `f` = '1'");
$perevedeno_otvet = mysql_fetch_row($perevedeno_zapros);
$perevedeno = $perevedeno_otvet[0];

mysql_close($podkluchenie);	

include('sbros_v_zayavku.html');

//echo "<pre>";
//print_r(array_keys($_SESSION));
//echo "</pre>";
?>