<?php

declare(strict_types=1);
error_reporting(-1);


/**
 * @param integer $data_integer
 * @return string
 */
function meta_error_mesage($data_integer)
{
    switch ($data_integer) {
        case 1:
            $return = "Превышен допустимый размер введённых данных и они были обрезаны.";
            break;
        case 2:
            $return = "Только кириллица, пробел, дефис и цифры.";
            break;
        case 3:
            $return = "Должно быть меньше введённых ключевых слов на этом шаге.";
            break;
        case 4:
            $return = "Должно быть больше ключевых слов в готовом наборе.";
            break;
        default:
            $return = "";
    }

    return $return;
}

/**
 * @return string
 */
function meta_errors_markup_list()
{
    $data_array_markup = array();
    if (isset($_SESSION["error_messages"])) {
        foreach ($_SESSION["error_messages"] as $item) {
            $item = htmlspecialchars($item, ENT_QUOTES | ENT_SUBSTITUTE | ENT_HTML5, 'utf-8');
            $data_array_markup[] = "<div class='error'>{$item}</div>";
        }
        $markup = implode("", $data_array_markup);
    } else {
        $markup = "";
    }

    return $markup;
}

/**
 * @param string $data_string
 * @param integer $data_width
 * @param integer $data_kws_count
 * @return array
 */
function meta_kws_input_string_to_array($data_string, $data_width, $data_kws_count)
{
    if (iconv_strlen($data_string, 'utf-8') > $data_width) {
        $data_string = mb_substr($data_string, 0, $data_width, 'utf-8');
        $_SESSION["error_messages"][] = meta_error_mesage(1);
    }
    $data_string = mb_strtolower(preg_replace(["/ {2,}/u", "/-{2,}/u", "/ -/u", "/- /u"], [" ", "-", "-", "-"], $data_string));
    $data_array = preg_split("/[\n,;]/u", $data_string, -1, PREG_SPLIT_NO_EMPTY);
    foreach ($data_array as &$value) {
        $value = trim(trim($value), "-");
        unset($value);
    }
    $data_array = array_values(array_unique(array_diff($data_array, array(""))));
    foreach ($data_array as $value) {
        if (!preg_match("/^[а-яё0-9 -]*$/u", $value)) {
            $_SESSION["error_messages"][] = meta_error_mesage(2);
            break;
        }
    }
    if (count($data_array) > $data_kws_count) {
        $_SESSION["error_messages"][] = meta_error_mesage(3);
    }

    return $data_array;
}

/**
 * @param array $arr_list
 * @param array $arr_checked
 * @return string
 */
function meta_kws_markup_checkbox_list($arr_list, $arr_checked)
{
    $markup = array();
    foreach ($arr_list as $kw) {
        if (in_array($kw, $arr_checked)) {
            $status = "checked";
        } else {
            $status = "";
        }
        $kw = htmlspecialchars($kw, ENT_QUOTES | ENT_SUBSTITUTE | ENT_HTML5, 'utf-8');
        $markup[] = "
                    <label class='label_highlight'>
                    <input type='checkbox'
                           name='arr_kws_marked[]'
                           {$status}
                           value = '{$kw}'>{$kw}</label>
                           ";
    }

    return implode("", $markup);
}

/**
 * @param integer $data_int
 * @return string
 */
function meta_kws_content_input($data_int)
{
    switch ($data_int) {
        case 1:
            $content_name = "arr_kws_query";
            break;
        case 2:
            $content_name = "arr_kws_addition";
            break;
        default:
            $content_name = array();
    }
    if (isset($_SESSION[$content_name])) {
        $content = htmlspecialchars(implode("\n", $_SESSION[$content_name]), ENT_QUOTES | ENT_SUBSTITUTE | ENT_HTML5, 'utf-8');
    } else {
        $content = "";
    }

    return $content;
}

/**
 * @return string
 */
function meta_kws_markup_state_amount()
{
    if (isset($_SESSION["arr_kws_state"]) and count($_SESSION["arr_kws_state"]) > 0) {
        $kws = array();
        foreach ($_SESSION["arr_kws_state"] as $kw) {
            $kws[] = htmlspecialchars($kw, ENT_QUOTES | ENT_SUBSTITUTE | ENT_HTML5, 'utf-8');
        }
        $markup = implode(", ", $kws) . "<span class='amount'>" . count($kws) . "</span>";
    } else {
        $markup = "Нет сохранённого состояния набора.";
    }
    $markup = "<div class='saved_set'>{$markup}</div>";

    return $markup;
}

/**
 * @param object $mysqli_stmt
 * @param integer $count_arr_kws_query
 * @param integer $max_choice_amount
 * @return array
 */
function meta_kws_array_selection($mysqli_stmt, $count_arr_kws_query, $max_choice_amount)
{
    if (!$mysqli_stmt->bind_param("ii", $count_arr_kws_query, $max_choice_amount)) {
        echo PHP_EOL . $mysqli_stmt->errno . " --> " . $mysqli_stmt->error . PHP_EOL;
    }
    if (!$mysqli_stmt->execute()) {
        echo PHP_EOL . $mysqli_stmt->errno . " --> " . $mysqli_stmt->error . PHP_EOL;
    }
    $data = "";
    $mysqli_stmt->bind_result($data);
    while ($mysqli_stmt->fetch()) {
        $arr_kws_selection[] = $data;
    }
    $mysqli_stmt->free_result();
    if (isset ($arr_kws_selection) && null != $arr_kws_selection) {
        return $arr_kws_selection;
    } else {
        return null;
    }
}
