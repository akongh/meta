<?php
session_start();
include ('metka_vxoda.php');

$id_pol = $_SESSION['id_pol'];
$imya_pol = $_SESSION['imya_pol'];
$el_p_pol = $_SESSION['el_p_pol'];
$vyvod_spiska = $_SESSION['vyvod_spiska'];
$dopolnenie_unikalnoe = $_SESSION['dopolnenie_unikalnoe'];

include('slova_nabory.php');
include('slova_nabory_pol.php');

include ('shag_2.html');
?>