<?php error_reporting(E_ALL ^E_NOTICE);
session_start();

include( 'meta_config.php' );

unset(
$_SESSION["oshibka_simvola"],
$_SESSION["oshibka_mnogo_op_slov"],
$_SESSION["oshibka_kolichestva"],
$_SESSION["_MASSIV_rezultata"],
$_SESSION["vyvod_spiska_flagov"],
$_SESSION["dopolnitelnye_slova"],
$_SESSION["sobranny_nabor"],
$_SESSION["massiv_itog"]
);

header("Location: http://".$site_domain_name."/shag_1.php");
?>