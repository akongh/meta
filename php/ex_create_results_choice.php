<?php
declare(strict_types=1);
error_reporting(-1);

session_start();
include($_SERVER['DOCUMENT_ROOT'] . '/meta_config_db.php');
include($_SERVER['DOCUMENT_ROOT'] . '/php/sql_prepared_statements.php');

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
    $_SESSION["kol_slov_russk"] = count($kws_ru);
}
if (isset($kws_en)) {
    $_SESSION["kol_slov_angl"] = count($kws_en);
} else {
    $_SESSION["kol_slov_angl"] = 0;
}

if (isset($kws_ru)) {
    $kwsset_time = time();
    $kwsset_ses = session_id();
    $kws_ru_to_db = $kws_ru;

    for ($i = 0; $i < count($kws_ru_to_db); $i++) {
        $kws_ru_to_db[$i] = preg_replace(["/ {2,}/", "/'/"], [" ", "\'"], trim($kws_ru_to_db[$i]));
    }

    if (!($stmt = $db_connect->prepare(SQL_CREATE_KWSET_ID))) {
        echo $db_connect->errno . " -> " . $db_connect->error;
    }
    if (!$stmt->bind_param("ss", $kwsset_time, $kwsset_ses)) {
        echo $stmt->errno . " -> " . $stmt->error;
    }
    if (!$stmt->execute()) {
        echo $stmt->errno . " -> " . $stmt->error;
    }

    for ($i = 0; $i < count($kws_ru_to_db); $i++) {
        if (!($stmt = $db_connect->prepare(SQL_CREATE_KWSET_KWS))) {
            echo $db_connect->errno . " -> " . $db_connect->error;
        }
        if (!$stmt->bind_param("s", $kws_ru_to_db[$i])) {
            echo $stmt->errno . " -> " . $stmt->error;
        }
        if (!$stmt->execute()) {
            echo $stmt->errno . " -> " . $stmt->error;
        }

        if (!($stmt = $db_connect->prepare(SQL_CREATE_KWSET_REL))) {
            echo $db_connect->errno . " -> " . $db_connect->error;
        }
        if (!$stmt->bind_param("sss", $kwsset_time, $kwsset_ses, $kws_ru_to_db[$i])) {
            echo $stmt->errno . " -> " . $stmt->error;
        }
        if (!$stmt->execute()) {
            echo $stmt->errno . " -> " . $stmt->error;
        }
    }

    $result_ru = implode(", ", $kws_ru);
}
if (isset($kws_en)) {
    $result_en = implode(", ", $kws_en);
}
if (isset($kws_mark_transl)) {
    $kws_mark_transl = implode("', '", $kws_mark_transl);
    $db_connect->query(sql_kws_mark_transl($kws_mark_transl));
}

$stmt->close();

$_SESSION["_REZULTAT_russk"] = $result_ru;
if (isset($result_en)) {
    $_SESSION["_REZULTAT_angl"] = $result_en;
}

$db_connect->close();
header("Location: //" . $_SERVER["HTTP_HOST"] . "/step_6.php");
