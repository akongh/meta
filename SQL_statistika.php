<?php //error_reporting(0);
include ('/home/webart/www/_upravlyalka.200slov.andrej.by/bd.php');

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

mysql_close($podkluchenie);
?>