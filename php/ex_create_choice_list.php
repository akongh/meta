<?php
declare(strict_types=1);
error_reporting(-1);

session_start();

require($_SERVER["DOCUMENT_ROOT"] . '/_privacy_path.php');
require($_SERVER["DOCUMENT_ROOT"] . '/php/sql_prepared_statements.php');
require($_SERVER["DOCUMENT_ROOT"] . '/php/regexp.php');

unset(
    $_SESSION["err_msg_empty_input"],
    $_SESSION["err_msg_illegal_char"],
    $_SESSION["err_msg_illegal_kws_query_amount"],
    $_SESSION["total_untranslated_ru_kws"]
);

if (isset($_POST["non_strict_choice"])) {
    $non_strict_choice = $_POST["non_strict_choice"];
}
$max_choice_amount = $_POST["max_choice_amount"];
$input_str_kws_query = $_POST["input_str_kws_query"];
$input_str_kws_query = mb_strtolower(htmlspecialchars(strip_tags(stripslashes($input_str_kws_query))), "utf-8");
$input_str_kws_query = preg_replace(["/ {2,}/", "/-{2,}/"], [" ", "-"], $input_str_kws_query);
$kws_query = preg_split("/[\n,;]/", $input_str_kws_query, -1, PREG_SPLIT_NO_EMPTY);

foreach ($kws_query as &$value) {
    $value = trim($value);
}
unset($value);

$kws_query = array_values(array_unique((array_diff($kws_query, array("")))));
$_SESSION["kws_query"] = $kws_query;

$count_kws_query = count($kws_query);

$err_mark = true;
if (!isset($_SESSION["kws_state"]) && $kws_query == null) {
    $_SESSION["err_msg_empty_input"] = "Необходимы опорные ключевые слова.";
    $err_mark = false;
}
if ($count_kws_query > 8) {
    $_SESSION["err_msg_illegal_kws_query_amount"] = "Не более 8-ми опорных ключевых слов.";
    $err_mark = false;
}
if ($count_kws_query > 0 && !preg_match($regex_check_ru_kws_query, implode("", $kws_query))) {
    $_SESSION["err_msg_illegal_char"] = "Только кириллица, цифры, пробел и&nbsp;дефис.";
    $err_mark = false;
}
if (false === $err_mark) {
    header("Location: //" . $_SERVER["HTTP_HOST"] . "/step_1.php");
    exit;
}

$str_kws_query = implode("','", $kws_query);

if (isset($non_strict_choice) && $count_kws_query > 1) {
    if (!($mysqli_stmt = $mysqli->prepare(sql_select_kws_choice($str_kws_query)))) {
        echo PHP_EOL . $mysqli->errno . " --> " . $mysqli->error . PHP_EOL;
    }
    for ($i = $count_kws_query; $i > 0; $i--) {
        if (!$mysqli_stmt->bind_param("ii", $i, $max_choice_amount)) {
            echo PHP_EOL . $mysqli_stmt->errno . " --> " . $mysqli_stmt->error . PHP_EOL;
        }
        if (!$mysqli_stmt->execute()) {
            echo PHP_EOL . $mysqli_stmt->errno . " --> " . $mysqli_stmt->error . PHP_EOL;
        }
        $mysqli_stmt->bind_result($data);

        while ($mysqli_stmt->fetch()) {
            $arr_of_result[] = $data;
        }

        $mysqli_stmt->free_result();

        if (isset($arr_of_result) && $arr_of_result != null) {
            $arr_of_result = array_values(array_unique(array_merge($kws_query, $arr_of_result)));

            if ($i == 1) {
                break;
            }
            if (count($arr_of_result) == $max_choice_amount) {
                break;
            }
            if (count($arr_of_result) > $max_choice_amount) {//todo:уже в базе обрезается
                $arr_of_result = array_slice($arr_of_result, 0, $max_choice_amount);
                break;
            }
        } else {
            if ($i == 1) {
                $arr_of_result = $kws_query;
            }
        }
    }

    $mysqli_stmt->close();
} else {
    if (!($mysqli_stmt = $mysqli->prepare(sql_select_kws_choice($str_kws_query)))) {
        echo PHP_EOL . $mysqli->errno . " --> " . $mysqli->error . PHP_EOL;
    }
    if (!$mysqli_stmt->bind_param("ii", $count_kws_query, $max_choice_amount)) {
        echo PHP_EOL . $mysqli_stmt->errno . " --> " . $mysqli_stmt->error . PHP_EOL;
    }
    if (!$mysqli_stmt->execute()) {
        echo PHP_EOL . $mysqli_stmt->errno . " --> " . $mysqli_stmt->error . PHP_EOL;
    }
    $mysqli_stmt->bind_result($data);

    while ($mysqli_stmt->fetch()) {
        $arr_of_result[] = $data;
    }

    $mysqli_stmt->free_result();
    $mysqli_stmt->close();

    if (isset($arr_of_result) && $arr_of_result != null) {
        $arr_of_result = array_values(array_unique(array_merge($kws_query, $arr_of_result)));
    } else {
        $arr_of_result = $kws_query;
    }
}

$_SESSION["arr_of_result"] = $arr_of_result;

$mysqli->close();
header("Location: //" . $_SERVER["HTTP_HOST"] . "/step_2.php");
