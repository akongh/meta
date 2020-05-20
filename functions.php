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
 * @return string
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

    return $arr_kws_selection;
}
