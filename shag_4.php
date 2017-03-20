<?php error_reporting(E_ALL ^E_NOTICE);
session_start();

include( 'meta_config.php' );

if(!isset($_SESSION["metka"]))
{
	header("Location: http://".$site_domain_name."/o_servise.php");
	}

$ochered = $_SESSION["ochered"];

$oshibka_kolichestva = $_SESSION["oshibka_kolichestva"];

include( 'shag_4.html' );




?>