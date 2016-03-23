<?php
session_start();
require_once('metka_vxoda.php');
unset($_SESSION["SESSION_massiv_itog"], $_POST["vvod_slov"], $_POST["flazhok"], $_POST["dopolnenie"]);
header("Location: /1_vvod_slov.php");
?>