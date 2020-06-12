<?php

declare(strict_types=1);
error_reporting(-1);

session_start();

require($_SERVER["DOCUMENT_ROOT"] . '/_privacy_path.php');

$na_sbros = $_POST["opornoe_slovo_sbrosa"];
$na_sbros = trim(mb_strtolower(htmlspecialchars(strip_tags(stripslashes($na_sbros))), "utf-8"));
$_MASSIV_na_sbros = preg_split("/[\n,;]/", $na_sbros, -1, PREG_SPLIT_NO_EMPTY);

for ($i = 0; $i < count($_MASSIV_na_sbros); $i++) {
    $_MASSIV_na_sbros[$i] = trim($_MASSIV_na_sbros[$i]);
}

$_MASSIV_na_sbros = array_values(array_unique((array_diff($_MASSIV_na_sbros, array("")))));
$_SQL_stroka_na_sbros = implode("','", $_MASSIV_na_sbros);

mysqli_query($mysqli, "
UPDATE `k-ts`
SET `k-ts`.`f` = 7
WHERE `k-ts`.`s` in ('" . $_SQL_stroka_na_sbros . "')
");

session_unset();
unset($_POST);
unset(
    $na_sbros,
    $_MASSIV_na_sbros,
    $_SQL_stroka_na_sbros
);

mysqli_close($mysqli);
header("Location: //" . $_SERVER["HTTP_HOST"] . "/management/translation_request.php");
