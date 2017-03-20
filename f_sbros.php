<?php error_reporting(E_ALL ^E_NOTICE);
session_start();

session_unset();
unset($_POST);

include( 'meta_config.php' );

header("Location: http://".$site_domain_name."/shag_1.php");
?>