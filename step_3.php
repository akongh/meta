<?php error_reporting( - 1 );
session_start();
include( 'meta_config.php' );
if ( ! isset( $_SESSION["metka"] ) ) {
    header( "Location: http://" . $site_domain_name . "/index.php" );
}
if ( isset( $_SESSION["sobranny_nabor"] ) ) {
    $sobranny_nabor = $_SESSION["sobranny_nabor"];
};
if ( isset( $_SESSION["oshibka_kolichestva"] ) ) {
    $oshibka_kolichestva = $_SESSION["oshibka_kolichestva"];
};
include( 'step_3.html' );