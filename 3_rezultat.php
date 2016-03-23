<?php
//if($_SERVER['PHP_SELF'] != "/index.php")
//{
//	header("Location: http://200slov.andrej.by");
//	}
session_start();
//var_dump($_SESSION["massiv_itog_zapom"]);
//echo "<br>";
//var_dump($_SESSION["massiv_itog"]);

$kol_slov_itog = $_SESSION["kol_slov_itog"];
$stroka_itog = $_SESSION["stroka_itog"];

include('SQL_slova_nabory.php');

include('shag_3.html');
?>