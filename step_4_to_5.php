<?php
declare(strict_types=1);
error_reporting(-1);

session_start();

require($_SERVER["DOCUMENT_ROOT"] . '/_privacy_path.php');
require($_SERVER["DOCUMENT_ROOT"] . '/sql_prepared_statements.php');

$_SESSION["arr_kws_ordered"] = $_POST["arr_kws_marked"];

if (!($mysqli_stmt_translation = $mysqli->prepare(SQL_SELECT_EN_TRANSLATION_AND_MEANING))) {
    echo PHP_EOL . $mysqli->errno . " --> " . $mysqli->error . PHP_EOL;
}
if (!($mysqli_stmt_statuses = $mysqli->prepare(SQL_SELECT_KW_STATUSES))) {
    echo PHP_EOL . $mysqli->errno . " --> " . $mysqli->error . PHP_EOL;
}

foreach ($_SESSION["arr_kws_ordered"] as $kw) {
    $arr_kw_translations[0] = $kw;

    if (!$mysqli_stmt_translation->bind_param("s", $kw)) {
        echo PHP_EOL . $mysqli_stmt_translation->errno . " --> " . $mysqli_stmt_translation->error . PHP_EOL;
    }
    if (!$mysqli_stmt_translation->execute()) {
        echo PHP_EOL . $mysqli_stmt_translation->errno . " --> " . $mysqli_stmt_translation->error . PHP_EOL;
    }
    $result = $mysqli_stmt_translation->get_result();
    $arr_kw_translations[1] = $result->fetch_all(MYSQLI_ASSOC);
    $mysqli_stmt_translation->free_result();

    if (!$mysqli_stmt_statuses->bind_param("s", $kw)) {
        echo PHP_EOL . $mysqli_stmt_statuses->errno . " --> " . $mysqli_stmt_statuses->error . PHP_EOL;
    }
    if (!$mysqli_stmt_statuses->execute()) {
        echo PHP_EOL . $mysqli_stmt_statuses->errno . " --> " . $mysqli_stmt_statuses->error . PHP_EOL;
    }
    $result = $mysqli_stmt_statuses->get_result();//var_dump($result->fetch_all(MYSQLI_ASSOC));exit;
    $arr_status = $result->fetch_all(MYSQLI_ASSOC);
    if (isset($arr_status) and count($arr_status) > 0) {
        $arr_kw_translations[2] = $arr_status[0]["f"];
    } else {
        $arr_kw_translations[2] = null;
    }
    $mysqli_stmt_statuses->free_result();

    if ($arr_kw_translations[2] == 0 or $arr_kw_translations[2] == 7 or $arr_kw_translations[2] == null) {
        $arr_kws_untranslated[] = $kw;
    }
    $arr_list_kws_translations[] = $arr_kw_translations;
}

$mysqli_stmt_translation->close();
$mysqli_stmt_statuses->close();
$mysqli->close();

if (isset($arr_kws_untranslated) and $arr_kws_untranslated != null) {
    $_SESSION["arr_kws_untranslated"] = $arr_kws_untranslated;
}
$_SESSION["arr_list_kws_translations"] = $arr_list_kws_translations;

header("Location: //" . $_SERVER["HTTP_HOST"] . "/step_5.php");
