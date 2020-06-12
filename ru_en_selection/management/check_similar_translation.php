<?php

declare(strict_types=1);
error_reporting(-1);

session_start();

require($_SERVER["DOCUMENT_ROOT"] . '/_privacy_path.php');

if (!isset($_POST["slovo_proverka"])) {
    $slovo = $_SESSION["original_kw"];
} else {
    $slovo = $_POST["slovo_proverka"];
}

$kw_ruolichestvo = mysqli_query($mysqli, "
	SELECT `kol`
	from `k-ts`
	where `s` = '" . $slovo . "'
	");
$n = 0;
while ($data = mysqli_fetch_array($kw_ruolichestvo)) {
    $kol[$n] = $data["kol"];
    $n++;
}
if (isset($kol[0])) {
    $kol = $kol[0];
}

$sql_select_en_translation_and_meaning = mysqli_query($mysqli, "
select `l-ts`.`s`, `tz`.`z`
from `k-ts`
join `k_l` on `k-ts`.`ids`=`k_l`.`idk`
join `l-ts` on `l-ts`.`ids`=`k_l`.`idl`
join `tz` on `tz`.`idz`=`k_l`.`idz`
where `k-ts`.`s`='" . $slovo . "'
");

$n = 0;
while ($rez = mysqli_fetch_array($sql_select_en_translation_and_meaning)) {
    $p[$n] = $rez["s"];
    $z[$n] = $rez["z"];
    $p_z[$n] = "<span class=\"perevod\">" . $p[$n] . "</span><span class=\"znachenie\"> — " . $z[$n] . "</span>";

    $n++;
}
if (isset($p_z)) {
    $p_z = implode("<hr class=\"otbivka_0\">", $p_z);
    $with_translation = "<hr class=\"otbivka_6\">" . $p_z . "<hr class=\"otbivka_6\">";
} else {
    $with_translation = "<hr class=\"otbivka_6\"><span class=\"perevoda_net\">…</span><hr class=\"otbivka_6\">";
}

unset($p_z, $p, $z);


require($_SERVER["DOCUMENT_ROOT"] . '/ru_en_selection/management/sql/SQL_choice.php');
$_SQL_rezultat_podbora = mysqli_query($mysqli, $_SQL_zapros_podbor);

$n = 0;
while ($data = mysqli_fetch_array($_SQL_rezultat_podbora)) {
    $arr_of_result[$n] = $data["s"];
    $n++;
}

if (isset($arr_of_result) && $arr_of_result != null) {
    $arr_of_result = array_values(array_unique($arr_of_result));
    for ($i = 0; $i < count($arr_of_result); $i++) {
        $_MASSIV_spisok_podbora[$i] = $arr_of_result[$i];
    }
}

if (isset($_MASSIV_spisok_podbora)) {
    $output_marked_kws_list = implode("<br>", $_MASSIV_spisok_podbora);
}


mysqli_close($mysqli);
require($_SERVER["DOCUMENT_ROOT"] . '/ru_en_selection/management/includes/check_similar_translation.php');
