<?php error_reporting(E_ALL ^E_NOTICE);
session_start();

include( 'meta_config.php' );


/////////////////////////////

$sost_nab = $_SESSION["massiv_itog"];
/*sort($sost_nab, SORT_STRING);*/
$_SESSION["sostoyanie_nabora"] = "<div class = \"rezultat_fon\"><span class = \"na_russk_angl\">Состояние набора</span><hr class=\"otbivka_24\">" . implode("; ", $sost_nab) . "<hr class=\"otbivka_24\">
<div class=\"statistika\">Ключевых слов в наборе — <span class=\"statistika_czyfra\">" . $_SESSION["kol_slov_itog"] . "</span>.</div></div>
<hr class=\"otbivka_12\">";
/////////////////////////////

$_SESSION["_MASSIV_sostoyanie_nabora"] = $_SESSION["massiv_itog"];

unset(
$_SESSION["dopolnitelnye_slova"],
$_SESSION["vyvod_spiska_flagov"],
$_SESSION["opornye_slova"],
$_SESSION["oshibka_kolichestva"]
);

header("Location: http://".$site_domain_name."/shag_1.php");
?>