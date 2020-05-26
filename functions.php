<?php
declare(strict_types=1);
error_reporting(-1);
/**
 * Meta functions.
 *
 * PHP version 7.3
 *
 * @package   Meta
 * @author    Andrei Korzhyts <andreikorzhyts@dmail.com>
 * @copyright 2018 Andrei Korzhyts, Elena Abrazhevich
 * @since     0.1.0
 */


/**
 * @param string $data_string
 * @return boolean
 */
function meta_kws_check_only_cyrillic($data_string)
{
    return preg_match("/^[а-яё\s\-0-9,;]*$/umDi", $data_string);
}

/**
 * @param string $data_string
 * @return array
 */
function meta_kws_input_string_to_array($data_string)
{
    $data_string = trim(mb_strtolower($data_string));
    $data_string = preg_replace(["/\s{2,}/", "/-{2,}/"], [" ", "-"], $data_string);
    $data_array = preg_split("/[\n,;]/", $data_string, -1, PREG_SPLIT_NO_EMPTY);
    foreach ($data_array as $value) {
        $value = trim($value);
    }
    $data_array = array_values(array_unique(array_diff($data_array, array(""))));

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
        $markup[] = "
                <label class='label-highlight'>
                <input type='checkbox'
                       name='arr_kws_marked[]'
                       {$status}
                       value = '{$kw}'>{$kw}</label>
                       ";
    }

    return implode("\n", $markup);
}

/**
 * @param array $data_array
 * @return string
 */
function meta_kws_markup_state_amount($data_array)
{
    return implode(", ", $data_array) . "
        <span class='counter'>" . count($data_array) . "</span>
        <br>
        <br>
        ";
}

/**
 * @param array $data_array
 * @return string
 */
function meta_markup_errors_list($data_array)
{
    foreach ($data_array as $item) {
        $data_array_markup[] = "<span class='error'>{$item}</span>";
    }
    return implode("<br>", $data_array_markup);
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

/**
 * @param integer $data_integer
 * @return string
 */
function meta_error_mesage($data_integer)
{
    switch ($data_integer) {
        case 1:
            $return = "Только кириллица, пробел, дефис и цифры.";
            break;
        case 2:
            $return = "Превышен объём отправляемых данных.";
            break;
        case 3:
            $return = "Не более 8-ми опорных ключевых слов.";
    }
    return $return;
}
