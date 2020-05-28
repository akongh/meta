<?php
declare(strict_types=1);
error_reporting(-1);

session_start();

//var_dump($_POST);

unset($_SESSION["error_messages"]);

require($_SERVER["DOCUMENT_ROOT"] . '/functions.php');

/*
 * INCOMING DATA
 */

// $_POST["arr_kws_marked"]

if (isset($_POST["arr_kws_marked"])) {
    $_SESSION["arr_kws_selection_marked"] = $_POST["arr_kws_marked"];
}

// $_POST["input_str_kws_addition"]

$_SESSION["arr_kws_addition"] = meta_kws_input_string_to_array($_POST["input_str_kws_addition"], 4096, 128);

/*
 * LOGIC
 */

if (!isset($_SESSION["arr_kws_state"])) {
    $arr_kws_state = array();
} else {
    $arr_kws_state = $_SESSION["arr_kws_state"];
}
if (!isset($_SESSION["arr_kws_selection_marked"])) {
    $arr_kws_selection_marked = array();
} else {
    $arr_kws_selection_marked = $_SESSION["arr_kws_selection_marked"];
}
if (!isset($_SESSION["arr_kws_addition"])) {
    $arr_kws_addition = array();
} else {
    $arr_kws_addition = $_SESSION["arr_kws_addition"];
}
$_SESSION["arr_kws_assembled"] = array_values(array_unique(array_merge($arr_kws_state, $arr_kws_selection_marked, $arr_kws_addition)));
$_SESSION["arr_kws_assembled_marked"] = $_SESSION["arr_kws_assembled"];

if (isset($_SESSION["error_messages"])) {
    header("Location: //" . $_SERVER["HTTP_HOST"] . "/step_2.php");
    exit;
}

if (isset($_POST["alphabetical_order"]) && $_POST["alphabetical_order"] == "on") {
    sort($_SESSION["arr_kws_assembled"], SORT_STRING);
}

header("Location: //" . $_SERVER["HTTP_HOST"] . "/step_3.php");
