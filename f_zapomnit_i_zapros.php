<?php
session_start();

unset($_SESSION["dopolnenie_unikalnoe"]);


$massiv_itog = $_SESSION["massiv_itog"];
$_SESSION["massiv_itog_zapom"] = $massiv_itog;
$massiv_itog_zapom = $_SESSION["massiv_itog_zapom"];

if(isset($massiv_itog_zapom))
{
	$massiv_itog_zapom = array_values(array_unique(array_merge($massiv_itog_zapom, $massiv_itog)));
	}
	else
	{
		$massiv_itog_zapom = $massiv_itog;
		}

$stroka_itog_zapom = implode("; ", $massiv_itog_zapom);
$_SESSION["stroka_itog_zapom"] = $stroka_itog_zapom;

header("Location: http://200slov.andrej.by");

?>