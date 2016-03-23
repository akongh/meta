<?php //error_reporting(0);
session_start();

session_unset();
unset($_POST);

include('podderzhat.html');

//echo "<pre>";
//print_r(array_keys($_SESSION));
//echo "</pre>";
?>