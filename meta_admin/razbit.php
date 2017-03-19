<?php //error_reporting(0);
session_start();

include ($_SERVER['DOCUMENT_ROOT'].'/meta_config_db.php');

$na_zayavke_zapros = mysqli_query( $db_connect, "SELECT COUNT(*) FROM `k-ts` WHERE `f` = '7'");
$na_zayavke_otvet = mysqli_fetch_row($na_zayavke_zapros);
$na_zayavke = $na_zayavke_otvet[0];

$perevedeno_zapros = mysqli_query( $db_connect, "SELECT COUNT(*) FROM `k-ts` WHERE `f` = '1'");
$perevedeno_otvet = mysqli_fetch_row($perevedeno_zapros);
$perevedeno = $perevedeno_otvet[0];

mysqli_close($db_connect);

$slovo_razbit = $_SESSION["slovo_original"];

include('razbit.html');
?>