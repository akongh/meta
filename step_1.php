<?php error_reporting(-1);
session_start();
$_SESSION["metka"] = true;

$opornye_slova = $_SESSION["opornye_slova"];

$oshibka_nichego_ne_vveli = $_SESSION["oshibka_nichego_ne_vveli"];
$oshibka_simvola = $_SESSION["oshibka_simvola"];
$oshibka_mnogo_op_slov = $_SESSION["oshibka_mnogo_op_slov"];

$sostoyanie_nabora = $_SESSION["sostoyanie_nabora"];

include( 'meta_config.php' );

include( 'step_1.html' );