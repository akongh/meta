<?php

declare(strict_types=1);
error_reporting(-1);

require_once($_SERVER["DOCUMENT_ROOT"] . "/search_hints/get_and_check.php");

if ("" === trim($basic_keywords_string) && "no_0-z" === $param0_z) {
    echo("-3");
    exit;
}

if ("no_0-z" === $param0_z) {
    $pond5_response = POND5_RESPONSE_FOR_ONE_BASIC_KEYWORD($basic_keywords_string, $related_parameter);
    $pond5_result = json_decode($pond5_response);
    if (is_string($pond5_result -> keywords)) {
        $pond5_result = json_encode(["no_result"]);
    } else {
        $pond5_result = json_encode($pond5_result -> keywords);
    }
} else if ("0-z" === $param0_z) {
    $a_z_letters_array = ["1","2","3","4","5","6","7","8","9","a","b","c","d","e","f","g","h","i","j","k","l","m","n","o","p","q","r","s","t","u","v","w","x","y","z"];

    foreach ($a_z_letters_array as $value) {
        $a_z_basic_keywords_string = $basic_keywords_string . $value;
        $pond5_response = POND5_RESPONSE_FOR_ONE_BASIC_KEYWORD($a_z_basic_keywords_string, $related_parameter);
        $pond5_result = json_decode($pond5_response);

        $a_z_hints_list[] = "---- " . mb_strtoupper($value) . " ----";

        if (isset($pond5_result -> keywords) && is_array($pond5_result -> keywords)) {
            foreach ($pond5_result -> keywords as $value2) {
                $a_z_hints_list[] = $value2;
            }
            unset($value2);
        }
    }
    unset($value);

    $pond5_result = json_encode($a_z_hints_list, JSON_UNESCAPED_UNICODE);
} else {
    $pond5_result = "Not created \$pond5_result";
}

echo($pond5_result);


/**
 * Functions.
 */

/**
 * Создаёт pond5-ответ для одного ОКС.
 *
 * @param string $_PARAM_basic_keyword
 * @param string $_PARAM_media_type
 * @return bool|string
 */
function POND5_RESPONSE_FOR_ONE_BASIC_KEYWORD(string $_PARAM_basic_keyword, string $_PARAM_media_type)
{
    if ("" !== $_PARAM_basic_keyword) {
        $_PARAM_basic_keyword = preg_replace("/ /", "+", $_PARAM_basic_keyword);
    }
    if ("footage" === $_PARAM_media_type) {
        $filter = "p5_video_filter";
    } else {
        $filter = "p5_sfx_filter";
    }
    $url="https://www.pond5.com/ajax/search/autocomplete?frag=" . $_PARAM_basic_keyword . "&lang=en_US&type=" . $_PARAM_media_type . "&search=" . $filter;

    $sesion = curl_init();
    curl_setopt($sesion, CURLOPT_URL, $url);
    curl_setopt($sesion, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($sesion, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/58.0.3029.97 Safari/537.36 Vivaldi/1.9.818.49');
    $pond5_response = curl_exec($sesion);
    curl_close($sesion);

    return $pond5_response;
}
