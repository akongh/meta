<?php

declare(strict_types=1);
error_reporting(-1);

$php_input_to_array = explode("\n", mb_strtolower(file_get_contents("php://input")));
$media_type = $php_input_to_array[0];
$basic_keywords_string = $php_input_to_array[1];

$data_width = 64;
if (iconv_strlen($basic_keywords_string, 'utf-8') > $data_width) {
    echo("-1");
    exit;
}

if (!preg_match("/^[a-z0-9'& -]*$/u", $basic_keywords_string)) {
    echo("-2"); // A0 - ' & z9
    exit;
}

$shutterstock_response = SHUTTERSTOCK_RESPONSE_FOR_ONE_BASIC_KEYWORD($basic_keywords_string, $media_type);
$clean_shutterstock_response = CLEANING_FOR_ONE_SHUTTERSTOCK_RESPONSE($shutterstock_response);
$shutterstock_result = json_encode($clean_shutterstock_response, JSON_UNESCAPED_UNICODE);

echo($shutterstock_result);


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
function SHUTTERSTOCK_RESPONSE_FOR_ONE_BASIC_KEYWORD(string $_PARAM_basic_keyword, string $_PARAM_media_type)
{
    if ($_PARAM_basic_keyword != "") {
        $_PARAM_basic_keyword = preg_replace("/ /", "+", $_PARAM_basic_keyword);
    }
    $anticache_time = time();
    $anticache_num = rand(100, 999);
    $anticache_id = $anticache_time . $anticache_num;
    $url = "https://www.shutterstock.com/api/autocomplete?q=" . $_PARAM_basic_keyword . "&mediaType=" . $_PARAM_media_type . "&_=" . $anticache_id;
    $sesion = curl_init();
    curl_setopt($sesion, CURLOPT_URL, $url);
    curl_setopt($sesion, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($sesion, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/58.0.3029.97 Safari/537.36 Vivaldi/1.9.818.49');
    $shutterstock_response = curl_exec($sesion);
    curl_close($sesion);

    return $shutterstock_response;
}

/**
 * Очищает от служебной информации массив подсказок для одного shutterstock-ответа.
 *
 * @param string $_PARAM_shutterstock_response
 * @return array
 */
function CLEANING_FOR_ONE_SHUTTERSTOCK_RESPONSE(string $_PARAM_shutterstock_response): array
{
    $clean_shutterstock_response = preg_replace("/ {2,}/", " ", $_PARAM_shutterstock_response);
    $clean_shutterstock_response = json_decode($clean_shutterstock_response, true);

    return $clean_shutterstock_response["data"]["autocompletions"];
}
