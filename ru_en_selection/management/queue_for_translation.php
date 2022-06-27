<?php

declare(strict_types=1);
error_reporting(-1);

session_start();
session_unset();
unset($_POST);

require($_SERVER["DOCUMENT_ROOT"] . "/_meta_privacy_db_connection.php");
require($_SERVER["DOCUMENT_ROOT"] . "/sql_prepared_statements.php");

$mysqli_result = $mysqli->query(SQL_SELECT_KWS_FOR_TRANSLATION);
$raw_kws_for_translation = $mysqli_result->fetch_all(MYSQLI_ASSOC);
$amount_kws_for_translation = $mysqli_result->num_rows;
$mysqli_result->free();

$mysqli->close();

if (0 < $amount_kws_for_translation) {
    $arr_kws_for_translation = array();
    foreach ($raw_kws_for_translation as $el) {
        $arr_kws_for_translation[] = htmlspecialchars($el["s"], ENT_QUOTES | ENT_SUBSTITUTE | ENT_HTML5, 'utf-8');
    }
    $html_kws_for_translation = implode("<br>", $arr_kws_for_translation);
} else {
    $html_kws_for_translation = "Заявок на перевод пока нет.";
}

//var_dump($_SESSION);
require($_SERVER["DOCUMENT_ROOT"] . '/ru_en_selection/management/includes/queue_for_translation.php');
