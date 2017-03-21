<?php error_reporting(-1);
session_start();

session_unset();
unset($_POST);

include( 'meta_config.php' );

include( 'o_servise.html' );




?>