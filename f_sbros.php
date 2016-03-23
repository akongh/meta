<?php //error_reporting(0);
session_start();

session_unset();
unset($_POST);

header("Location: http://proba.200slov.andrej.by");
?>