<?php error_reporting( - 1 );
session_start();
include( $_SERVER['DOCUMENT_ROOT'] . '/meta_config.php' );

if ( ! isset( $_SESSION["metka"] ) ) {
    header( "Location: http://" . $site_domain_name . "/index.php" );
}
if ( isset( $_SESSION["ochered"] ) ) {
    $ochered = $_SESSION["ochered"];
};
if ( isset( $_SESSION["oshibka_kolichestva"] ) ) {
    $oshibka_kolichestva = $_SESSION["oshibka_kolichestva"];
};
include( 'step_4.html' );