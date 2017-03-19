<?php //error_reporting(0);
include ('/home/webart/www/meta_access/db_connect.php');

$kir_kol_slov_zapros = mysql_query("SELECT COUNT(*) FROM `k-ts`");
$kir_kol_slov_otvet = mysql_fetch_row($kir_kol_slov_zapros);
$_SESSION["kir_kol_slov"] = $kir_kol_slov_otvet[0];

$kir_kol_naborov_zapros = mysql_query("SELECT COUNT(*) FROM `k-tn`");
$kir_kol_naborov_otvet = mysql_fetch_row($kir_kol_naborov_zapros);
$_SESSION["kir_kol_naborov"] = $kir_kol_naborov_otvet[0];

$lat_kol_slov_zapros = mysql_query("SELECT COUNT(*) FROM `l-ts`");
$lat_kol_slov_otvet = mysql_fetch_row($lat_kol_slov_zapros);
$_SESSION["lat_kol_slov"] = $lat_kol_slov_otvet[0];

$lat_kol_naborov_zapros = mysql_query("SELECT COUNT(*) FROM `l-tn`");
$lat_kol_naborov_otvet = mysql_fetch_row($lat_kol_naborov_zapros);
$_SESSION["lat_kol_naborov"] = $lat_kol_naborov_otvet[0];



$na_zayavke_zapros = mysql_query("SELECT COUNT(*) FROM `k-ts` WHERE `f` = '7'");
$na_zayavke_otvet = mysql_fetch_row($na_zayavke_zapros);
$na_zayavke = $na_zayavke_otvet[0];

$perevedeno_zapros = mysql_query("SELECT COUNT(*) FROM `k-ts` WHERE `f` = '1'");
$perevedeno_otvet = mysql_fetch_row($perevedeno_zapros);
$perevedeno = $perevedeno_otvet[0];

mysql_close($podkluchenie);
?>