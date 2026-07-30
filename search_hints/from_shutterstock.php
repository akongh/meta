<?php

declare(strict_types=1);
error_reporting(-1);

require_once($_SERVER["DOCUMENT_ROOT"] . "/search_hints/get_and_check.php");

$shutterstock_response = SHUTTERSTOCK_RESPONSE_FOR_ONE_BASIC_KEYWORD($basic_keywords_string, $related_parameter);

echo($shutterstock_response);


/**
 * Functions.
 */

/**
 * Создаёт shutterstock-ответ для одного ОКС.
 *
 * @param string $_PARAM_basic_keyword
 * @param string $_PARAM_media_type
 * @return bool|string
 */
function SHUTTERSTOCK_RESPONSE_FOR_ONE_BASIC_KEYWORD(string $_PARAM_basic_keyword, string $_PARAM_media_type): bool|string
{
    $url = "https://www.shutterstock.com/napi/autocomplete?pageSize=&q=" . $_PARAM_basic_keyword . "&mediaType=" . $_PARAM_media_type . "&language=en";

    $session = curl_init();
    curl_setopt($session, CURLOPT_URL, $url);
    curl_setopt($session, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($session, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/58.0.3029.97 Safari/537.36 Vivaldi/1.9.818.49');
    $shutterstock_response = curl_exec($session);
    unset($session);

    return $shutterstock_response;
}
