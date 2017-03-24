<?php error_reporting( - 1 );
session_start();
$_SESSION["metka"] = true;
if ( isset( $_SESSION["opornye_slova"] ) ) {
    $opornye_slova = $_SESSION["opornye_slova"];
};
if ( isset( $_SESSION["oshibka_nichego_ne_vveli"] ) ) {
    $oshibka_nichego_ne_vveli = $_SESSION["oshibka_nichego_ne_vveli"];
};
if ( isset( $_SESSION["oshibka_simvola"] ) ) {
    $oshibka_simvola = $_SESSION["oshibka_simvola"];
};
if ( isset( $_SESSION["oshibka_mnogo_op_slov"] ) ) {
    $oshibka_mnogo_op_slov = $_SESSION["oshibka_mnogo_op_slov"];
};
if ( isset( $_SESSION["sostoyanie_nabora"] ) ) {
    $sostoyanie_nabora = $_SESSION["sostoyanie_nabora"];
};
include( 'meta_config.php' );
include( 'step_1.html' );