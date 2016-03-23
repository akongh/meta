<?php
session_start();

$vyvod_spiska = $_SESSION['vyvod_spiska'];
$dopolnenie_unikalnoe = $_SESSION['dopolnenie_unikalnoe'];

include('slova_nabory.php');

include ('shag_2.html');
?>