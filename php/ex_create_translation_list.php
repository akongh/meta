<?php
declare(strict_types=1);
error_reporting(-1);

session_start();

require($_SERVER["DOCUMENT_ROOT"] . '/_privacy_path.php');
require($_SERVER["DOCUMENT_ROOT"] . '/php/sql_prepared_statements.php');

$_SESSION["arr_kws_ordered"] = $_POST["arr_kws_marked"];

if (!($mysqli_stmt_translation = $mysqli->prepare(SQL_SELECT_EN_TRANSLATION_AND_MEANING))) {
    echo PHP_EOL . $mysqli->errno . " --> " . $mysqli->error . PHP_EOL;
}

foreach ($_SESSION["arr_kws_ordered"] as $kw) {
    if (!$mysqli_stmt_translation->bind_param("s", $kw)) {
        echo PHP_EOL . $mysqli_stmt_translation->errno . " --> " . $mysqli_stmt_translation->error . PHP_EOL;
    }
    if (!$mysqli_stmt_translation->execute()) {
        echo PHP_EOL . $mysqli_stmt_translation->errno . " --> " . $mysqli_stmt_translation->error . PHP_EOL;
    }
    $result = $mysqli_stmt_translation->get_result();
    $arr_kw_translations[0] = $kw;
    $arr_kw_translations[1] = $result->fetch_all(MYSQLI_ASSOC);
    $arr_list_kws_translations[] = $arr_kw_translations;
    $mysqli_stmt_translation->free_result();
}

$_SESSION["arr_list_kws_translations"] = $arr_list_kws_translations;

header("Location: //" . $_SERVER["HTTP_HOST"] . "/step_5.php");
