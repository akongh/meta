<?php

declare(strict_types=1);
error_reporting(-1);

session_start();

require($_SERVER["DOCUMENT_ROOT"] . '/_meta_privacy_db_connection.php');

unset($_SESSION["original_kw"]);

$propustit_zapros = mysqli_query($mysqli, "SELECT COUNT(*) FROM `k-ts` WHERE `f` = '5'");
$propustit_otvet = mysqli_fetch_row($propustit_zapros);
$propustit = $propustit_otvet[0];

$perevedeno_zapros = mysqli_query($mysqli, "SELECT COUNT(*) FROM `k-ts` WHERE `f` = '1'");
$perevedeno_otvet = mysqli_fetch_row($perevedeno_zapros);
$perevedeno = $perevedeno_otvet[0];

$kw_ruolichestvo = mysqli_query($mysqli, "
	SELECT `s` slovo, `kol`
	from `k-ts`
	where `f` = 0
	ORDER BY `k-ts`.`kol` DESC
	LIMIT 1
	");

while ($data = mysqli_fetch_array($kw_ruolichestvo)) {
    $slovo[0] = $data["slovo"];
    $kol[0] = $data["kol"];
}

if (isset($slovo[0])) {
    $slovo = $slovo[0];
}

if (isset($slovo)) {
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
}
if (isset($p_z)) {
    $p_z = implode("<hr class=\"otbivka_0\">", $p_z);
    $with_translation = "<hr class=\"otbivka_6\">" . $p_z . "<hr class=\"otbivka_6\">";
} else {
    $with_translation = "<hr class=\"otbivka_6\"><span class=\"perevoda_net\">…</span><hr class=\"otbivka_6\">";
}

unset($p_z, $p, $z);

if (isset($kol[0])) {
    $kol = $kol[0];
}

if (isset($slovo)) {
    $_SESSION["original_kw"] = $slovo;
    require($_SERVER["DOCUMENT_ROOT"] . '/ru_en_selection/management/includes/translation_frequency.php');
} else {
    require($_SERVER["DOCUMENT_ROOT"] . '/ru_en_selection/management/includes/no_keyword_for_translation.php');
}

mysqli_close($mysqli);
unset($slovo);
