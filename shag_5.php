<?php error_reporting(-1);
session_start();

include( 'meta_config.php' );

if(!isset($_SESSION["metka"]))
{
	header("Location: http://".$site_domain_name."/index.php");
	}

$s_perevodom = $_SESSION["s_perevodom"];
$pro_zayavku = $_SESSION["pro_zayavku"];

include( 'shag_5.html' );

unset($_SESSION["pro_zayavku"]);




?>