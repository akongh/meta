<?php error_reporting(E_ALL ^E_NOTICE);
session_start();

include( 'meta_config.php' );

if(!isset($_SESSION["metka"]))
{
	header("Location: http://".$site_domain_name."/o_servise.php");
	}

$kol_slov_russk = $_SESSION["kol_slov_russk"];
$kol_slov_angl = $_SESSION["kol_slov_angl"];

$_REZULTAT_russk = $_SESSION["_REZULTAT_russk"];
$_REZULTAT_angl = $_SESSION["_REZULTAT_angl"];

if(isset($_SESSION["_REZULTAT_russk_neperevedennye"]))
{
	$_REZULTAT_russk_neperevedennye = $_SESSION["_REZULTAT_russk_neperevedennye"];
	}

include( 'shag_6.html' );




?>