<?php

declare(strict_types=1);
error_reporting(-1);

session_start();

//var_dump($_POST);

require($_SERVER["DOCUMENT_ROOT"] . '/_privacy_path.php');
require($_SERVER["DOCUMENT_ROOT"] . '/sql_prepared_statements.php');

if (isset($_POST["russk"])) {
    $_SESSION["arr_kws_ru"] = $_POST["russk"];
    $arr_kws_ru_to_db = $_SESSION["arr_kws_ru"];

    // Creating of number of new set

    if (!$mysqli_stmt = $mysqli->prepare(SQL_INSERT_CREATE_KWS_SET_ID)) {
        echo PHP_EOL . $mysqli->errno . " --> " . $mysqli->error . PHP_EOL;
    }
    if (!$mysqli_stmt->execute()) {
        echo PHP_EOL . $mysqli_stmt->errno . " --> " . $mysqli_stmt->error . PHP_EOL;
    }

    $kwsset_id = $mysqli->insert_id;

    // Adding of new keywords to database

    if (!$mysqli_stmt = $mysqli->prepare(SQL_INSERT_CREATE_KWS_SET_KWS)) {
        echo PHP_EOL . $mysqli->errno . " --> " . $mysqli->error . PHP_EOL;
    }
    foreach ($arr_kws_ru_to_db as $kw_ru_to_db) {
        if (!$mysqli_stmt->bind_param("s", $kw_ru_to_db)) {
            echo PHP_EOL . $mysqli_stmt->errno . " --> " . $mysqli_stmt->error . PHP_EOL;
        }
        if (!$mysqli_stmt->execute()) {
            echo PHP_EOL . $mysqli_stmt->errno . " --> " . $mysqli_stmt->error . PHP_EOL;
        }
    }

    // Creating of relations of keywords with set

    if (!$mysqli_stmt = $mysqli->prepare(SQL_INSERT_CREATE_KWS_SET_RELATIONS)) {
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
    $_SESSION["arr_kws_en_marked"] = $_SESSION["arr_kws_en"];
}

if (isset($_POST["zayavka"])) {
    $_SESSION["arr_kws_untranslated"] = $_POST["zayavka"];
    $kws_mark_transl = sql_prepare_array_to_string_query($_SESSION["arr_kws_untranslated"]);
    $mysqli->query(sql_update_mark_kws_for_translation($kws_mark_transl));
}

$mysqli_stmt->close();
$mysqli->close();

header("Location: //" . $_SERVER["HTTP_HOST"] . "/step_6.php");
