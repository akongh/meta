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
        <span class='counter'>{count($data_array)}</span>
        <br>
        <br>
        ";
}
