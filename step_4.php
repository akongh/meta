<?php error_reporting(-1);
session_start();

include( 'meta_config.php' );

if(!isset($_SESSION["metka"]))
{
	header("Location: http://".$site_domain_name."/index.php");
	}

$ochered = $_SESSION["ochered"];

$oshibka_kolichestva = $_SESSION["oshibka_kolichestva"];

include( 'step_4.html' );




?>