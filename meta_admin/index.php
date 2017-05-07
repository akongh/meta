<?php error_reporting( - 1 );
session_start();
include( $_SERVER['DOCUMENT_ROOT'] . '/meta_config_db.php' );

include( 'sql/SQL_statistic.php' );
$kir_kol_slov_otvet          = mysqli_fetch_row( $kir_kol_slov_zapros );
$kir_kol_naborov_otvet       = mysqli_fetch_row( $kir_kol_naborov_zapros );
$lat_kol_slov_otvet          = mysqli_fetch_row( $lat_kol_slov_zapros );
$na_zayavke_otvet            = mysqli_fetch_row( $na_zayavke_zapros );
$perevedeno_otvet            = mysqli_fetch_row( $perevedeno_zapros );
$hint_translation_response   = mysqli_fetch_row( $hint_translation_querry );
$hint_request_response       = mysqli_fetch_row( $hint_request_querry );
$_SESSION["kir_kol_slov"]    = $kir_kol_slov_otvet[0];
$_SESSION["kir_kol_naborov"] = $kir_kol_naborov_otvet[0];
$_SESSION["lat_kol_slov"]    = $lat_kol_slov_otvet[0];
$na_zayavke                  = $na_zayavke_otvet[0];
$perevedeno                  = $perevedeno_otvet[0];
$hint_translation            = $hint_translation_response[0];
$hint_request                = $hint_request_response[0];

$kir_kol_slov    = $_SESSION["kir_kol_slov"];
$kir_kol_naborov = $_SESSION["kir_kol_naborov"];
$lat_kol_slov    = $_SESSION["lat_kol_slov"];

if ( isset( $_SESSION["opornye_slova"] ) ) {
    $opornye_slova = $_SESSION["opornye_slova"];
}
if ( isset( $_SESSION["oshibka_simvola"] ) ) {
    $oshibka_simvola = $_SESSION["oshibka_simvola"];
}
if ( isset( $_SESSION["sostoyanie_nabora"] ) ) {
    $sostoyanie_nabora = $_SESSION["sostoyanie_nabora"];
}
if ( isset( $_SESSION["obnovlenie_chastoty"] ) ) {
    $obnovlenie_chastoty = $_SESSION["obnovlenie_chastoty"];
}

mysqli_close( $db_connect );
include( 'html/meta_admin.html' );