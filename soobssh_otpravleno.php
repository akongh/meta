<?php
session_start();
require_once('metka_vxoda.php');

$id_pol = $_SESSION['id_pol'];
$imya_pol = $_SESSION['imya_pol'];
$el_p_pol = $_SESSION['el_p_pol'];

require_once('soobssh_otpravleno.html');
?>