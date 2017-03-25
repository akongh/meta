<?php error_reporting( - 1 );
session_start();
session_unset();
unset( $_POST );
include( $_SERVER['DOCUMENT_ROOT'] . '/meta_config.php' );
header( "Location: http://" . $site_domain_name . "/step_1.php" );