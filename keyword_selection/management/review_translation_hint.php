<?php

declare(strict_types=1);
error_reporting(-1);

session_start();

require($_SERVER["DOCUMENT_ROOT"] . '/_privacy_path.php');

$kw_en = $_SESSION["kw_en"];

$sql_select_en_translation_and_meaning = mysqli_query($mysqli, "
select `k-ts`.`s`, `tz`.`z`
from `l-ts`
join `k_l` on `l-ts`.`ids`=`k_l`.`idl`
join `k-ts` on `k-ts`.`ids`=`k_l`.`idk`
join `tz` on `tz`.`idz`=`k_l`.`idz`
where `l-ts`.`s`='" . preg_replace("/'/", "\'", $kw_en) . "'
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
    $with_translation = "<span class = \"russk\">" . $kw_en . "</span><hr class=\"otbivka_6\">" . $p_z;
} else {
    $with_translation = "<span class = \"russk\">" . $kw_en . "</span><hr class=\"otbivka_6\"><span class = \"perevoda_net\">…</span>";
}

unset($p_z, $p, $z);

mysqli_close($mysqli);
require($_SERVER["DOCUMENT_ROOT"] . '/keyword_selection/management/includes/review_translation_hint.php');
