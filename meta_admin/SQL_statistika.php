<?php error_reporting(-1);
include ($_SERVER['DOCUMENT_ROOT'].'/meta_config_db.php');

$kir_kol_slov_zapros = mysqli_query( $db_connect, "SELECT COUNT(*) FROM `k-ts`");
$kir_kol_slov_otvet = mysqli_fetch_row($kir_kol_slov_zapros);
$_SESSION["kir_kol_slov"] = $kir_kol_slov_otvet[0];

$kir_kol_naborov_zapros = mysqli_query( $db_connect, "SELECT COUNT(*) FROM `k-tn`");
$kir_kol_naborov_otvet = mysqli_fetch_row($kir_kol_naborov_zapros);
$_SESSION["kir_kol_naborov"] = $kir_kol_naborov_otvet[0];

$lat_kol_slov_zapros = mysqli_query( $db_connect, "SELECT COUNT(*) FROM `l-ts`");
$lat_kol_slov_otvet = mysqli_fetch_row($lat_kol_slov_zapros);
$_SESSION["lat_kol_slov"] = $lat_kol_slov_otvet[0];



$na_zayavke_zapros = mysqli_query( $db_connect, "SELECT COUNT(*) FROM `k-ts` WHERE `f` = '7'");
$na_zayavke_otvet = mysqli_fetch_row($na_zayavke_zapros);
$na_zayavke = $na_zayavke_otvet[0];

$perevedeno_zapros = mysqli_query( $db_connect, "SELECT COUNT(*) FROM `k-ts` WHERE `f` = '1'");
$perevedeno_otvet = mysqli_fetch_row($perevedeno_zapros);
$perevedeno = $perevedeno_otvet[0];

mysqli_close($db_connect);
?>