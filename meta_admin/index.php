<?php error_reporting( - 1 );
session_start();
include( 'sql/SQL_statistika.php' );
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
include( 'meta_admin.html' );