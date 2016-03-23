<?php
session_start();

$kol_slov_itog = $_SESSION["kol_slov_itog"];
$stroka_itog = $_SESSION["stroka_itog"];

include('SQL_slova_nabory.php');

include('shag_3.html');
?>