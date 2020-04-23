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
    $_SESSION["err_msg_illegal_basis_kws_amount"],
    $_SESSION["total_untranslated_ru_kws"]
);

if (isset($_POST["non_strict_choice"])) {
    $non_strict_choice = $_POST["non_strict_choice"];
}
$max_choice_amount = $_POST["max_choice_amount"];
$input_str_basis_kws = $_POST["input_str_basis_kws"];
$input_str_basis_kws = mb_strtolower(htmlspecialchars(strip_tags(stripslashes($input_str_basis_kws))), "utf-8");
$input_str_basis_kws = preg_replace(["/ {2,}/", "/-{2,}/"], [" ", "-"], $input_str_basis_kws);
$arr_basis_kws = preg_split("/[\n,;]/", $input_str_basis_kws, -1, PREG_SPLIT_NO_EMPTY);

foreach ($arr_basis_kws as &$value) {
    $value = trim($value);
}
unset($value);

$arr_basis_kws = array_values(array_unique((array_diff($arr_basis_kws, array("")))));
$_SESSION["arr_basis_kws"] = $arr_basis_kws;

$count_arr_basis_kws = count($arr_basis_kws);

$err_mark = true;
if (!isset($_SESSION["arr_state_of_kws_set"]) && $arr_basis_kws == null) {
    $_SESSION["err_msg_empty_input"] = "<span class='error'>Необходимы опорные ключевые слова.</span><br>";
    $err_mark = false;
}
if ($count_arr_basis_kws > 8) {
    $_SESSION["err_msg_illegal_basis_kws_amount"] = "<span class='error'>Не более 8-ми опорных ключевых слов.</span><br>";
    $err_mark = false;
}
if ($count_arr_basis_kws > 0) {
    $check_str_ru_basis_kws = implode("", $arr_basis_kws);
    if (!preg_match($regex_check_ru_basis_kws, $check_str_ru_basis_kws)) {
        $_SESSION["err_msg_illegal_char"] = "<span class='error'>Только кириллица, цифры, пробел и&nbsp;дефис.</span><br>";
        $err_mark = false;
    }
}
if (false === $err_mark) {
    header("Location: //" . $_SERVER["HTTP_HOST"] . "/step_1.php");
    exit;
}

$str_basis_kws = implode("','", $arr_basis_kws);

if (isset($non_strict_choice) && $count_arr_basis_kws > 1) {
    for ($i = $count_arr_basis_kws; $i > 0; $i--) {
        if (!($mysqli_stmt = $mysqli->prepare(sql_select_kws_choice($str_basis_kws)))) {
            echo PHP_EOL . $mysqli->errno . " --> " . $mysqli->error . PHP_EOL;
        }
        if (!$mysqli_stmt->bind_param("ii", $i, $max_choice_amount)) {
            echo PHP_EOL . $mysqli_stmt->errno . " --> " . $mysqli_stmt->error . PHP_EOL;
        }
        if (!$mysqli_stmt->execute()) {
            echo PHP_EOL . $mysqli_stmt->errno . " --> " . $mysqli_stmt->error . PHP_EOL;
        }
        $mysqli_stmt->bind_result($data, $count);

        $n = 0;
        while ($mysqli_stmt->fetch()) {
            $arr_of_result[$n] = $data;
            $n++;
        }

        $mysqli_stmt->free_result();
        $mysqli_stmt->close();

        if (isset($arr_of_result) && $arr_of_result != null) {
            $arr_of_result = array_values(array_unique(array_merge($arr_basis_kws, $arr_of_result)));

            if ($i == 1) {
                break;
            }
            if (count($arr_of_result) == $max_choice_amount) {
                break;
            }
            if (count($arr_of_result) > $max_choice_amount) {
                $arr_of_result = array_slice($arr_of_result, 0, $max_choice_amount);
                break;
            }
        } else {
            if ($i == 1) {
                $arr_of_result = $arr_basis_kws;
            }
        }
//        if ( isset( $arr_of_result ) && $arr_of_result != null ) {
//            $arr_of_result = array_values( array_unique( array_merge( $arr_basis_kws, $arr_of_result ) ) );
//            if ( count( $arr_of_result ) > $count_arr_basis_kws ) {
//                if ( count( $arr_of_result ) > $max_choice_amount ) {
//                    $arr_of_result = array_slice( $arr_of_result, 0, $max_choice_amount );
//                }
//                break;
//            }
//        } else {
//            $arr_of_result = $arr_basis_kws;
//        }
    }
} else {
    if (!($mysqli_stmt = $mysqli->prepare(sql_select_kws_choice($str_basis_kws)))) {
        echo PHP_EOL . $mysqli->errno . " --> " . $mysqli->error . PHP_EOL;
    }
    if (!$mysqli_stmt->bind_param("ii", $count_arr_basis_kws, $max_choice_amount)) {
        echo PHP_EOL . $mysqli_stmt->errno . " --> " . $mysqli_stmt->error . PHP_EOL;
    }
    if (!$mysqli_stmt->execute()) {
        echo PHP_EOL . $mysqli_stmt->errno . " --> " . $mysqli_stmt->error . PHP_EOL;
    }
    $mysqli_stmt->bind_result($data, $count);

    $n = 0;
    while ($mysqli_stmt->fetch()) {
        $arr_of_result[$n] = $data;
        $n++;
    }

    $mysqli_stmt->free_result();
    $mysqli_stmt->close();

    if (isset($arr_of_result) && $arr_of_result != null) {
        $arr_of_result = array_values(array_unique(array_merge($arr_basis_kws, $arr_of_result)));
    } else {
        $arr_of_result = $arr_basis_kws;
    }
}

$_SESSION["arr_of_result"] = $arr_of_result;

for ($i = 0; $i < count($arr_of_result); $i++) {
    if ($i < $count_arr_basis_kws) {
        $_MASSIV_spisok_podbora[$i] = "
        <label class='label-highlight'>
        <input type='checkbox' name='slova_s_flagom[]' checked value = '" . $arr_of_result[$i] . "'>
        " . $arr_of_result[$i] . "
        </label>";
    } else {
        $_MASSIV_spisok_podbora[$i] = "
        <label class='label-highlight'>
        <input type='checkbox' name='slova_s_flagom[]' value = '" . $arr_of_result[$i] . "'>
        " . $arr_of_result[$i] . "
        </label>";
    }
}
if (isset($_MASSIV_spisok_podbora)) {
    $output_marked_kws_list = implode("<br>", $_MASSIV_spisok_podbora) . "
        <br>
        <br>
        ";
    $_SESSION["output_marked_kws_list"] = $output_marked_kws_list;
}

$mysqli->close();
header("Location: //" . $_SERVER["HTTP_HOST"] . "/step_2.php");
