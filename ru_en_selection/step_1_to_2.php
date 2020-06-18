<?php

declare(strict_types=1);
error_reporting(-1);

session_start();

//var_dump($_POST);

require($_SERVER["DOCUMENT_ROOT"] . '/_meta_privacy_db_connection.php');
require($_SERVER["DOCUMENT_ROOT"] . '/sql_prepared_statements.php');
require($_SERVER["DOCUMENT_ROOT"] . '/functions.php');

/*
 * INCOMING DATA
 */

$_SESSION["arr_kws_query"] = meta_kws_input_string_to_array($_POST["input_str_kws_query"], 256, 8);
$_SESSION["arr_kws_selection_marked"] = $_SESSION["arr_kws_query"];

if (isset($_SESSION["error_messages"])) {
    header("Location: //" . $_SERVER["HTTP_HOST"] . "/ru_en_selection/step_1.php");
    exit;
}

switch ((int)$_POST["max_choice_amount"]) {
    case 64:
        $max_choice_amount = 64;
        break;
    case 128:
        $max_choice_amount = 128;
        break;
    default:
        $max_choice_amount = 64;
}

/*
 * LOGIC
 */

$count_arr_kws_query = count($_SESSION["arr_kws_query"]);

$str_kws_query = sql_prepare_array_to_string_query($_SESSION["arr_kws_query"]);

if (isset($_POST["non_strict_choice"]) && $count_arr_kws_query > 1) {
    if (!$mysqli_stmt = $mysqli->prepare(sql_select_kws_choice($str_kws_query))) {
        echo PHP_EOL . $mysqli->errno . PHP_EOL . $mysqli->error . PHP_EOL;
    }
    for ($i = $count_arr_kws_query; $i > 0; $i--) {
        $arr_kws_selection = meta_kws_array_selection($mysqli_stmt, $i, $max_choice_amount);

        if (isset($arr_kws_selection) && $arr_kws_selection != null) {
            $arr_kws_selection = array_values(array_unique(array_merge($_SESSION["arr_kws_query"], $arr_kws_selection)));

            if ($i == 1) {
                break;
            }
            if (count($arr_kws_selection) >= $max_choice_amount) {
                break;
            }
        } else {
            if ($i == 1) {
                $arr_kws_selection = $_SESSION["arr_kws_query"];
            }
        }
    }

    $mysqli_stmt->close();
} else {
    if (!$mysqli_stmt = $mysqli->prepare(sql_select_kws_choice($str_kws_query))) {
        echo PHP_EOL . $mysqli->errno . PHP_EOL . $mysqli->error . PHP_EOL;
    }
    $arr_kws_selection = meta_kws_array_selection($mysqli_stmt, $count_arr_kws_query, $max_choice_amount);

    $mysqli_stmt->close();

    if (isset($arr_kws_selection) && $arr_kws_selection != null) {
        $arr_kws_selection = array_values(array_unique(array_merge($_SESSION["arr_kws_query"], $arr_kws_selection)));
    } else {
        $arr_kws_selection = $_SESSION["arr_kws_query"];
    }
}

$_SESSION["arr_kws_selection"] = $arr_kws_selection;

$mysqli->close();
header("Location: //" . $_SERVER["HTTP_HOST"] . "/ru_en_selection/step_2.php");
