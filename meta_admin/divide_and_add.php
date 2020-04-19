<?php error_reporting( - 1 );
session_start();
require( $_SERVER["DOCUMENT_ROOT"] . '/meta_config_db.php' );

$na_zayavke_zapros = mysqli_query( $mysqli, "SELECT COUNT(*) FROM `k-ts` WHERE `f` = '7'" );
$na_zayavke_otvet  = mysqli_fetch_row( $na_zayavke_zapros );
$na_zayavke        = $na_zayavke_otvet[0];

$perevedeno_zapros = mysqli_query( $mysqli, "SELECT COUNT(*) FROM `k-ts` WHERE `f` = '1'" );
$perevedeno_otvet  = mysqli_fetch_row( $perevedeno_zapros );
$perevedeno        = $perevedeno_otvet[0];

$slovo_razbit = $_SESSION["original_kw"];

mysqli_close( $mysqli );
require( $_SERVER["DOCUMENT_ROOT"] . '/meta_admin/includes/divide_and_add.php' );