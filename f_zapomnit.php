<?php //error_reporting(0);
session_start();

//$_SESSION["sostoyanie_nabora"] = implode("; ", $_SESSION["massiv_itog"]) . "<hr class=\"otbivka_24\">
//<div class=\"statistika\">Слов в наборе — <span class=\"statistika_czyfra\">" . $_SESSION["kol_slov_itog"] . "</span>.</div>";

/////////////////////////////
$sost_nab = $_SESSION["massiv_itog"];
sort($sost_nab, SORT_STRING);
$_SESSION["sostoyanie_nabora"] = implode("; ", $sost_nab) . "<hr class=\"otbivka_12\">
<div class=\"statistika\">Слов в наборе — <span class=\"statistika_czyfra\">" . $_SESSION["kol_slov_itog"] . "</span>.</div>
<hr class=\"otbivka_12\">";
/////////////////////////////

$_SESSION["_MASSIV_sostoyanie_nabora"] = $_SESSION["massiv_itog"];

unset(
$_SESSION["dopolnitelnye_slova"],
$_SESSION["vyvod_spiska_flagov"],
$_SESSION["opornye_slova"],
$_SESSION["oshibka_kolichestva"]
);

header("Location: http://200slov.andrej.by");
?>