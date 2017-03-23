<?php error_reporting( - 1 );
session_start();

include( '../meta_config.php' );

unset(
	$_SESSION["oshibka_simvola"],
	$_SESSION["oshibka_kolichestva"],
	$_SESSION["sobranny_nabor"],
	$_SESSION["massiv_itog"]
);

header( "Location: http://" . $site_domain_name . "/step_2.php" );