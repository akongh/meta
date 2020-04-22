<?php
declare(strict_types=1);
error_reporting(-1);

session_start();
require($_SERVER["DOCUMENT_ROOT"] . '/_privacy_path.php');
require($_SERVER["DOCUMENT_ROOT"] . '/php/sql_prepared_statements.php');

if (isset($_POST["russk"])) {
    $kws_ru = array_values(array_unique($_POST["russk"]));
}
if (isset($_POST["angl"])) {
    $kws_en = array_values(array_unique($_POST["angl"]));
}
if (isset($_POST["zayavka"])) {
    $kws_mark_transl = $_POST["zayavka"];
}

if (isset($kws_ru)) {
    $_SESSION["amount_chosen_ru_kws"] = count($kws_ru);
    $_SESSION["resulting_ru_kws_set"] = implode(", ", $kws_ru);

    $kwsset_time = time();
    $kws_ru_to_db = $kws_ru;

    for ($i = 0; $i < count($kws_ru_to_db); $i++) {
        $kws_ru_to_db[$i] = preg_replace(["/ {2,}/", "/'/"], [" ", "\'"], trim($kws_ru_to_db[$i]));//todo: is it necessary "/ {2,}/" --> " " ?
    }

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

    if (!($mysqli_stmt = $mysqli->prepare(SQL_INSERT_CREATE_KWS_SET_KWS))) {
        echo PHP_EOL . $mysqli->errno . " --> " . $mysqli->error . PHP_EOL;
    }
    if (!$mysqli_stmt->bind_param("s", $kw_ru_to_db)) {
        echo PHP_EOL . $mysqli_stmt->errno . " --> " . $mysqli_stmt->error . PHP_EOL;
    }
    for ($i = 0; $i < count($kws_ru_to_db); $i++) {
        $kw_ru_to_db = $kws_ru_to_db[$i];
        if (!$mysqli_stmt->execute()) {
            echo PHP_EOL . $mysqli_stmt->errno . " --> " . $mysqli_stmt->error . PHP_EOL;
        }
    }

    // Создание связей ключевых слов с набором todo:transl

    if (!($mysqli_stmt = $mysqli->prepare(SQL_INSERT_CREATE_KWS_SET_RELATIONS))) {
        echo PHP_EOL . $mysqli->errno . " --> " . $mysqli->error . PHP_EOL;
    }
    if (!$mysqli_stmt->bind_param("is", $kwsset_id, $kw_ru_to_db)) {
        echo PHP_EOL . $mysqli_stmt->errno . " --> " . $mysqli_stmt->error . PHP_EOL;
    }
    for ($i = 0; $i < count($kws_ru_to_db); $i++) {
        $kw_ru_to_db = $kws_ru_to_db[$i];
        if (!$mysqli_stmt->execute()) {
            echo PHP_EOL . $mysqli_stmt->errno . " --> " . $mysqli_stmt->error . PHP_EOL;
        }
    }
}
if (isset($kws_en)) {
    $_SESSION["amount_chosen_en_kws"] = count($kws_en);
    $_SESSION["resulting_en_kws_set"] = implode(", ", $kws_en);
} else {
    $_SESSION["amount_chosen_en_kws"] = 0;
}
if (isset($kws_mark_transl)) {
    $kws_mark_transl = implode("', '", $kws_mark_transl);
    $mysqli->query(sql_update_mark_kws_for_translation($kws_mark_transl));
}

$mysqli_stmt->close();
$mysqli->close();

header("Location: //" . $_SERVER["HTTP_HOST"] . "/step_6.php");
