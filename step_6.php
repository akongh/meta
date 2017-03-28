<?php error_reporting( - 1 );
session_start();
include( $_SERVER['DOCUMENT_ROOT'] . '/meta_config.php' );

if ( ! isset( $_SESSION["metka"] ) ) {
    header( "Location: http://" . $site_domain_name . "/index.php" );
}

$kol_slov_russk = $_SESSION["kol_slov_russk"];
$kol_slov_angl  = $_SESSION["kol_slov_angl"];

$_REZULTAT_russk = $_SESSION["_REZULTAT_russk"];
if ( isset( $_SESSION["_REZULTAT_angl"] ) ) {
    $_REZULTAT_angl = $_SESSION["_REZULTAT_angl"];
};
if ( isset( $_SESSION["_REZULTAT_russk_neperevedennye"] ) ) {
    $_REZULTAT_russk_neperevedennye = $_SESSION["_REZULTAT_russk_neperevedennye"];
}

include( 'html/step_6.html' );