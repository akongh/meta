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
function kws_string_check($data_string)
{
    return preg_match("/^[а-яёА-ЯЁ0-9 \-]+$/iu", $data_string);
}

/**
 * @param string $data_string
 * @return array
 */
function kws_string_to_array($data_string)
{
    $data_string = trim(mb_strtolower(htmlspecialchars(strip_tags(stripslashes($data_string))), "utf-8"));
    $data_string = preg_replace(["/ {2,}/", "/-{2,}/"], [" ", "-"], $data_string);
    $data_array = preg_split("/[\n,;]/", $data_string, -1, PREG_SPLIT_NO_EMPTY);
    foreach ($data_array as &$value) {
        $value = trim($value);
    }
    unset($value);
    $data_array = array_values(array_unique(array_diff($data_array, array(""))));

    return $data_array;
}

/**
 * @param array $arr_list
 * @param array $arr_checked
 * @return string
 */
function kws_list_markup($arr_list, $arr_checked)
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

    return implode("<br>", $markup);
}

/**
 * @param array $data_array
 * @return string
 */
function kws_state_markup($data_array)
{
    return implode("; ", $data_array) . "
        <span class='counter'>" . count($data_array) . "</span>
        <br>
        <br>
        ";
}

/**
 * @param string $data_string
 * @return string
 */
function err_msg_markup($data_string)
{
    return "<span class='error'>{$data_string}</span><br>";
}

/**
 * @param object $mysqli_stmt
 * @param integer $count_arr_kws_query
 * @param integer $max_choice_amount
 * @return array
 */
function arr_kws_selection($mysqli_stmt, $count_arr_kws_query, $max_choice_amount)
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
