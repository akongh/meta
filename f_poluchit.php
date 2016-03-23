<?php
session_start();

$vr_nabora = time();
$ses = session_id();
$massiv_itog = $_SESSION["massiv_itog"];

include ('SQL_sozdat_nabor.php');

session_unset();
unset($_POST);

header("Location: http://proba.200slov.andrej.by");
?>