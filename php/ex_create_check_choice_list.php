<?php
declare(strict_types=1);
error_reporting(-1);

session_start();

require($_SERVER["DOCUMENT_ROOT"] . '/php/regexp.php');
require($_SERVER["DOCUMENT_ROOT"] . '/functions.php');

unset(
    $_SESSION["err_msg_illegal_char"],
    $_SESSION["err_msg_of_kws_amount"],
    $_SESSION["arr_kws_addition"],
    $_SESSION["total_untranslated_ru_kws"]
);

if (isset($_POST["arr_kws_marked"])) {
    $arr_kws_selection_marked = $_SESSION["arr_kws_selection_marked"] = $_POST["arr_kws_marked"];
}
$arr_kws_selection = $_SESSION["arr_kws_selection"];

//рисуем массив результата с отмеченными словами
foreach ($arr_kws_selection as $kw) {
    if (isset($arr_marked_kws)) {
        if (in_array($kw, $arr_marked_kws)) {
            $spisok[] = "<label class='label-highlight'><input type='checkbox' name='marked_kws[]' checked value = '{$kw}'>{$kw}</label>";
        } else {
            $spisok[] = "<label class='label-highlight'><input type='checkbox' name='marked_kws[]' value = '{$kw}'>{$kw}</label>";
        }
    } else {
        $spisok[] = "<label class='label-highlight'><input type='checkbox' name='marked_kws[]' value = '{$kw}'>{$kw}</label>";
    }
}
if (isset($spisok) && $spisok != null) {
    $output_marked_kws_list = implode("<br>", $spisok) . "
    <br>
    <br>
    ";
    $_SESSION["output_marked_kws_list"] = $output_marked_kws_list;
}
//делаем массив из дополнительных слов
$input_str_kws_addition = $_POST["input_str_kws_addition"];
$arr_kws_addition = kws_string_to_array($input_str_kws_addition);

for ($i = 0; $i < count($arr_additional_kws); $i++) {
    $arr_additional_kws[$i] = trim($arr_additional_kws[$i]);
}

$arr_additional_kws = array_values(array_unique((array_diff($arr_additional_kws, array("")))));
//удаляем из дополнительных слов те, которые отмечены флажком в подборе
if (isset($arr_marked_kws) && isset($arr_additional_kws)) {
    for ($i = 0; $i < count($arr_additional_kws); $i++) {
        if (!in_array($arr_additional_kws[$i], $arr_marked_kws)) {
            $dopolnenie_unikalnoe[$i] = $arr_additional_kws[$i];
        }
    }
} elseif (!isset($arr_marked_kws) && isset($arr_additional_kws)) {
    $dopolnenie_unikalnoe = $arr_additional_kws;
}
//делаем строку с переносами из массива уникального дополненния
if (isset($dopolnenie_unikalnoe)) {
    $additional_kws = implode("\n", $dopolnenie_unikalnoe);
    $_SESSION["arr_kws_adding"] = $additional_kws;
}

//делаем вывод ошибки символа, если она есть
if (isset($dopolnenie_unikalnoe) && count($dopolnenie_unikalnoe) > 0) {
    $proverka_simvola = implode("", $dopolnenie_unikalnoe);
    if (!preg_match($regex_check_ru_kws_query, $proverka_simvola)) {
        $_SESSION["err_msg_illegal_char"] = "Только кириллица, цифры, пробел и&nbsp;дефис.";
    }
}
//итоговый массив из подбора, дополнения и состояния
if (isset($arr_marked_kws) && isset($dopolnenie_unikalnoe)) {
    $resulting_arr = array_values(array_unique(array_merge($arr_marked_kws, $dopolnenie_unikalnoe)));
} elseif (isset($arr_marked_kws) && !isset($dopolnenie_unikalnoe)) {
    $resulting_arr = $arr_marked_kws;
} elseif (!isset($arr_marked_kws) && isset($dopolnenie_unikalnoe)) {
    $resulting_arr = $dopolnenie_unikalnoe;
}


if (isset($_SESSION["kws_state"]) && $resulting_arr != null) {
    $kws_state = $_SESSION["kws_state"];
    $resulting_arr = array_values(array_unique(array_merge($kws_state, $resulting_arr)));
} elseif (isset($_SESSION["kws_state"]) && $resulting_arr == null) {
    $resulting_arr = $_SESSION["kws_state"];
}

//ещё одна проверка на смесь кирилицы и латиницы
if (isset($resulting_arr)) {
    $resulting_arr = array_values(array_unique((array_diff($resulting_arr, array("")))));
    if (count($resulting_arr) > 0) {
        $proverka_simvola = implode("", $resulting_arr);
        if (!preg_match($regex_check_ru_kws_query, $proverka_simvola)) {
            $_SESSION["err_msg_illegal_char"] = "Только кириллица, цифры, пробел и&nbsp;дефис.";
        }
    }
}
//остаёмся исправлять ошибки
if (isset($_SESSION["err_msg_illegal_char"])) {
    header("Location: //" . $_SERVER["HTTP_HOST"] . "/step_2.php");
    exit;
}
//переходим к третьему шагу, если нет ошибок
$total_kws_amount = count($resulting_arr);
$_SESSION["total_kws_amount"] = $total_kws_amount;

for ($i = 0; $i < count($resulting_arr); $i++) {
    $assembled_kws_set[$i] = "<label class='label-highlight'><input type='checkbox' name='resulting_arr[]' checked value = '{$resulting_arr[$i]}'>{$resulting_arr[$i]}</label>";
}
if (isset($assembled_kws_set)) {
    //сортировать или нет по алфавиту
    if (isset($_POST["alphabetical_order"]) && $_POST["alphabetical_order"] == "on") {
        sort($assembled_kws_set, SORT_STRING);
    }
    unset($_POST["alphabetical_order"]);
    $assembled_kws_set = implode("<br>\n", $assembled_kws_set);
}
if (isset($assembled_kws_set)) {
    $_SESSION["assembled_kws_set"] = $assembled_kws_set;
}
if (isset($resulting_arr)) {
    $_SESSION["resulting_arr"] = $resulting_arr;
}
header("Location: //" . $_SERVER["HTTP_HOST"] . "/step_3.php");
