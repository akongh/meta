<?php

declare(strict_types=1);
error_reporting(-1);

session_start();

require($_SERVER["DOCUMENT_ROOT"] . '/_meta_privacy_db_connection.php');

require($_SERVER["DOCUMENT_ROOT"] . '/ru_en_selection/management/SQL_statistic.php');
$amount_ru_kws_otvet = mysqli_fetch_row($amount_ru_kws_zapros);
$amount_ru_kws_set_otvet = mysqli_fetch_row($amount_ru_kws_set_zapros);
$amount_en_kws_otvet = mysqli_fetch_row($amount_en_kws_zapros);
$na_zayavke_otvet = mysqli_fetch_row($na_zayavke_zapros);
$perevedeno_otvet = mysqli_fetch_row($perevedeno_zapros);
$hint_translation_response = mysqli_fetch_row($hint_translation_querry);
$hint_request_response = mysqli_fetch_row($hint_request_querry);
$_SESSION["amount_ru_kws"] = $amount_ru_kws_otvet[0];
$_SESSION["amount_ru_kws_set"] = $amount_ru_kws_set_otvet[0];
$_SESSION["amount_en_kws"] = $amount_en_kws_otvet[0];
$na_zayavke = $na_zayavke_otvet[0];
$perevedeno = $perevedeno_otvet[0];
$hint_translation = $hint_translation_response[0];
$hint_request = $hint_request_response[0];

$amount_ru_kws = $_SESSION["amount_ru_kws"];
$amount_ru_kws_set = $_SESSION["amount_ru_kws_set"];
$amount_en_kws = $_SESSION["amount_en_kws"];

if (isset($_SESSION["basis_kws"])) {
    $basis_kws = $_SESSION["basis_kws"];
}
if (isset($_SESSION["err_msg_illegal_char"])) {
    $err_msg_illegal_char = $_SESSION["err_msg_illegal_char"];
}
if (isset($_SESSION["state_of_kws_set"])) {
    $state_of_kws_set = $_SESSION["state_of_kws_set"];
}
if (isset($_SESSION["amount_updated_frequencies"])) {
    $amount_updated_frequencies = $_SESSION["amount_updated_frequencies"];
}

mysqli_close($mysqli);
require($_SERVER["DOCUMENT_ROOT"] . '/ru_en_selection/management/includes/index.php');
