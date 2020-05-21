<?php
declare(strict_types=1);
error_reporting(-1);

session_start();

require($_SERVER["DOCUMENT_ROOT"] . '/functions.php');

unset(
    $_SESSION["err_msg_illegal_char"],
    $_SESSION["err_msg_of_kws_amount"],
);

if (isset($_POST["arr_kws_marked"])) {
    $_SESSION["arr_kws_selection_marked"] = $_POST["arr_kws_marked"];
}

//делаем массив из дополнительных слов
$input_str_kws_addition = $_POST["input_str_kws_addition"];
$_SESSION["arr_kws_addition"] = kws_string_to_array($input_str_kws_addition);

//делаем вывод ошибки символа, если она есть
if (isset($_SESSION["arr_kws_addition"]) && count($_SESSION["arr_kws_addition"]) > 0) {
    if (kws_string_check(implode("", $_SESSION["arr_kws_addition"]))) {
        $_SESSION["err_msg_illegal_char"] = "Только кириллица, цифры, пробел и&nbsp;дефис.";
    }
}

//итоговый массив из подбора, дополнения и состояния
$_SESSION["arr_kws_assembled"] = array_values(array_unique(array_merge($_SESSION["arr_kws_selection_marked"], $_SESSION["arr_kws_addition"], $_SESSION["kws_state"])));

//остаёмся исправлять ошибки
if (isset($_SESSION["err_msg_illegal_char"])) {
    header("Location: //" . $_SERVER["HTTP_HOST"] . "/step_2.php");
    exit;
}

//переходим к третьему шагу, если нет ошибок
if (isset($_SESSION["arr_kws_assembled"])) {
    //сортировать или нет по алфавиту
    if (isset($_POST["alphabetical_order"]) && $_POST["alphabetical_order"] == "on") {
        sort($_SESSION["arr_kws_assembled"], SORT_STRING);
    }
    unset($_POST["alphabetical_order"]);
}

header("Location: //" . $_SERVER["HTTP_HOST"] . "/step_3.php");
