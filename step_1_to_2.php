<?php
declare(strict_types=1);
error_reporting(-1);

session_start();

//var_dump($_POST);

unset($_SESSION["error_messages"]);

require($_SERVER["DOCUMENT_ROOT"] . '/_privacy_path.php');
require($_SERVER["DOCUMENT_ROOT"] . '/sql_prepared_statements.php');
require($_SERVER["DOCUMENT_ROOT"] . '/functions.php');

$arr_kws_query = kws_string_to_array($_POST["input_str_kws_query"]);
$_SESSION["arr_kws_query"] = $arr_kws_query;
$count_arr_kws_query = count($arr_kws_query);
$max_choice_amount = $_POST["max_choice_amount"];

$err_mark = true;
if (!isset($_SESSION["arr_kws_state"]) && $arr_kws_query == null) {
    $_SESSION["err_msg_empty_input"] = "Необходимы опорные ключевые слова.";
    $err_mark = false;
}
if ($count_arr_kws_query > 8) {
    $_SESSION["err_msg_illegal_kws_query_amount"] = "Не более 8-ми опорных ключевых слов.";
    $err_mark = false;
}
if ($count_arr_kws_query > 0 && !kws_string_check(implode("", $arr_kws_query))) {
    $_SESSION["err_msg_illegal_char"] = "Только кириллица, цифры, пробел и&nbsp;дефис.";
    $err_mark = false;
}
if (false === $err_mark) {
    header("Location: //" . $_SERVER["HTTP_HOST"] . "/step_1.php");
    exit;
}

$str_kws_query = implode("','", $arr_kws_query);

if (isset($_POST["non_strict_choice"]) && $count_arr_kws_query > 1) {
    if (!$mysqli_stmt = $mysqli->prepare(sql_select_kws_choice($str_kws_query))) {
        echo PHP_EOL . $mysqli->errno . " --> " . $mysqli->error . PHP_EOL;
    }
    for ($i = $count_arr_kws_query; $i > 0; $i--) {
        $arr_kws_selection = arr_kws_selection($mysqli_stmt, $count_arr_kws_query, $max_choice_amount);

        if (isset($arr_kws_selection) && $arr_kws_selection != null) {
            $arr_kws_selection = array_values(array_unique(array_merge($arr_kws_query, $arr_kws_selection)));

            if ($i == 1) {
                break;
            }
            if (count($arr_kws_selection) >= $max_choice_amount) {
                break;
            }
        } else {
            if ($i == 1) {
                $arr_kws_selection = $arr_kws_query;
            }
        }
    }

    $mysqli_stmt->close();
} else {
    if (!$mysqli_stmt = $mysqli->prepare(sql_select_kws_choice($str_kws_query))) {
        echo PHP_EOL . $mysqli->errno . " --> " . $mysqli->error . PHP_EOL;
    }
    $arr_kws_selection = arr_kws_selection($mysqli_stmt, $count_arr_kws_query, $max_choice_amount);

    $mysqli_stmt->close();

    if (isset($arr_kws_selection) && $arr_kws_selection != null) {
        $arr_kws_selection = array_values(array_unique(array_merge($arr_kws_query, $arr_kws_selection)));
    } else {
        $arr_kws_selection = $arr_kws_query;
    }
}

$_SESSION["arr_kws_selection"] = $arr_kws_selection;

$mysqli->close();
header("Location: //" . $_SERVER["HTTP_HOST"] . "/step_2.php");
