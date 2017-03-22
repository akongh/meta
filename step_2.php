<?php error_reporting( - 1 );
session_start();
include( 'meta_config.php' );
if ( ! isset( $_SESSION["metka"] ) ) {
    header( "Location: http://" . $site_domain_name . "/index.php" );
}
$vyvod_spiska_flagov = $_SESSION["vyvod_spiska_flagov"];
$dopolnitelnye_slova = $_SESSION["dopolnitelnye_slova"];
$oshibka_simvola     = $_SESSION["oshibka_simvola"];
$sostoyanie_nabora   = $_SESSION["sostoyanie_nabora"];
include( 'step_2.html' );