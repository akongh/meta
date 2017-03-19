<?php error_reporting(0);
session_start();

session_unset();
unset($_POST);

include( 'meta_config.php' );

include( 'o_servise.html' );

//echo "<pre>";
//print_r(array_keys($_SESSION));
//echo "</pre>";
?>