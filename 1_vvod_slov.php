<?php
session_start();
include('metka_vxoda.php');

$id_pol = $_SESSION['id_pol'];
$imya_pol = $_SESSION['imya_pol'];
$el_p_pol = $_SESSION['el_p_pol'];

include('slova_nabory.php');
include('slova_nabory_pol.php');

include('shag_1.html');
?>
