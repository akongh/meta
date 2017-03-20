<?php error_reporting(E_ALL ^E_NOTICE);
session_start();

session_unset();
unset($_POST);

include( 'meta_config.php' );

include( 'o_servise.html' );




?>