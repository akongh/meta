<?php
declare(strict_types=1);
error_reporting(-1);

session_start();
require($_SERVER["DOCUMENT_ROOT"] . '/_privacy_path.php');
require($_SERVER["DOCUMENT_ROOT"] . '/php/sql_prepared_statements.php');

if (isset($_POST["russk"])) {
    $_SESSION["arr_kws_ru"] = $_POST["russk"];
    $kwsset_time = time();

    // Создание номера нового набора todo:transl

    if (!($mysqli_stmt = $mysqli->prepare(SQL_INSERT_CREATE_KWS_SET_ID))) {
        echo PHP_EOL . $mysqli->errno . " --> " . $mysqli->error . PHP_EOL;
    }
    if (!$mysqli_stmt->bind_param("i", $kwsset_time)) {
        echo PHP_EOL . $mysqli_stmt->errno . " --> " . $mysqli_stmt->error . PHP_EOL;
    }
    if (!$mysqli_stmt->execute()) {
        echo PHP_EOL . $mysqli_stmt->errno . " --> " . $mysqli_stmt->error . PHP_EOL;
    }

    $kwsset_id = $mysqli->insert_id;

    // Добавление новых ключевых слов в БД todo:transl

    foreach ($_SESSION["arr_kws_ru"] as $kw_ru) {
        $arr_kws_ru_to_db[] = preg_replace(["/ {2,}/", "/'/"], [" ", "\'"], trim($kw_ru));//todo: is it necessary "/ {2,}/" --> " " ?
    }
    $str_kws_ru_to_db = implode("','", $arr_kws_ru_to_db);

    if (!($mysqli_stmt = $mysqli->prepare(SQL_INSERT_CREATE_KWS_SET_KWS))) {
        echo PHP_EOL . $mysqli->errno . " --> " . $mysqli->error . PHP_EOL;
    }
    if (!$mysqli_stmt->bind_param("s", $str_kws_ru_to_db)) {
        echo PHP_EOL . $mysqli_stmt->errno . " --> " . $mysqli_stmt->error . PHP_EOL;
    }
    if (!$mysqli_stmt->execute()) {
        echo PHP_EOL . $mysqli_stmt->errno . " --> " . $mysqli_stmt->error . PHP_EOL;
    }

    // Создание связей ключевых слов с набором todo:transl

    if (!($mysqli_stmt = $mysqli->prepare(SQL_INSERT_CREATE_KWS_SET_RELATIONS))) {
        echo PHP_EOL . $mysqli->errno . " --> " . $mysqli->error . PHP_EOL;
    }
    foreach ($arr_kws_ru_to_db as $kw_ru_to_db) {
        if (!$mysqli_stmt->bind_param("is", $kwsset_id, $kw_ru_to_db)) {
            echo PHP_EOL . $mysqli_stmt->errno . " --> " . $mysqli_stmt->error . PHP_EOL;
        }
        if (!$mysqli_stmt->execute()) {
            echo PHP_EOL . $mysqli_stmt->errno . " --> " . $mysqli_stmt->error . PHP_EOL;
        }
    }
}

if (isset($_POST["angl"])) {
    $_SESSION["arr_kws_en"] = $_POST["angl"];
}

if (isset($_POST["zayavka"])) {
    $_SESSION["arr_kws_untranslated"] = $_POST["zayavka"];
    $kws_mark_transl = implode("','", $_SESSION["arr_kws_untranslated"]);
    $mysqli->query(sql_update_mark_kws_for_translation($kws_mark_transl));
}

$mysqli_stmt->close();
$mysqli->close();

header("Location: //" . $_SERVER["HTTP_HOST"] . "/step_6.php");
