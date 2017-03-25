<?php error_reporting( - 1 );
session_start();
include( $_SERVER['DOCUMENT_ROOT'] . '/meta_config.php' );

if ( ! isset( $_SESSION["metka"] ) ) {
    header( "Location: http://" . $site_domain_name . "/index.php" );
}
if ( isset( $_SESSION["vyvod_spiska_flagov"] ) ) {
    $vyvod_spiska_flagov = $_SESSION["vyvod_spiska_flagov"];
};
if ( isset( $_SESSION["dopolnitelnye_slova"] ) ) {
    $dopolnitelnye_slova = $_SESSION["dopolnitelnye_slova"];
};
if ( isset( $_SESSION["oshibka_simvola"] ) ) {
    $oshibka_simvola = $_SESSION["oshibka_simvola"];
};
if ( isset( $_SESSION["sostoyanie_nabora"] ) ) {
    $sostoyanie_nabora = $_SESSION["sostoyanie_nabora"];
};
include( 'step_2.html' );