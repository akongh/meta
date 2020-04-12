<?php error_reporting( - 1 );
session_start();

$sost_nab = $_SESSION["massiv_itog"];
/*sort($sost_nab, SORT_STRING);*/
$_SESSION["sostoyanie_nabora"] = implode( "; ", $sost_nab ) . "
<span class='counter'>" . $_SESSION["kol_slov_itog"] . "</span>
<br>
<br>
";

$_SESSION["_MASSIV_sostoyanie_nabora"] = $_SESSION["massiv_itog"];

unset(
    $_SESSION["dopolnitelnye_slova"],
    $_SESSION["vyvod_spiska_flagov"],
    $_SESSION["opornye_slova"],
    $_SESSION["oshibka_kolichestva"]
);
header( "Location: //" . $_SERVER["HTTP_HOST"] . "/step_1.php" );