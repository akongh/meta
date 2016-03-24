<?php error_reporting(0);
session_start();

unset(
$_SESSION["oshibka_simvola"],
$_SESSION["oshibka_kolichestva"],
$_SESSION["sobranny_nabor"],
$_SESSION["massiv_itog"]
);

header("Location: http://meta.afoteris.com/shag_2.php");
?>