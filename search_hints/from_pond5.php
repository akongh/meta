<?php

declare(strict_types=1);
error_reporting(-1);

require_once($_SERVER["DOCUMENT_ROOT"] . "/search_hints/get_and_check.php");

$pond5_response = POND5_RESPONSE_FOR_ONE_BASIC_KEYWORD($basic_keywords_string, $related_parameter_2);
//echo $pond5_response;exit();
if ("" !== $pond5_response) {
    $pond5_result = json_decode($pond5_response);
    if (is_string($pond5_result->keywords)) { // "Fragment not in database"
        $pond5_result = json_encode(["no_result"]);
    } else {
        $pond5_result = json_encode($pond5_result->keywords);
    }
} else {
    $pond5_result = json_encode(["no_result"]);
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
function POND5_RESPONSE_FOR_ONE_BASIC_KEYWORD(string $_PARAM_basic_keyword, string $_PARAM_media_type): bool|string
{
    if ("footage" === $_PARAM_media_type) {
        $filter = "p5_video_filter";
    } else {
        $filter = "p5_sfx_filter";
    }
    $_PARAM_basic_keyword = preg_replace(" ", "%20", $_PARAM_basic_keyword);
//    https://www.pond5.com/ajax/search/autocomplete?frag=KWRD&lang=en_US&type=Footage&search=p5_video_filter
//    https://www.pond5.com/ajax/search/autocomplete?frag=KWRD&lang=en_US&type=sfx&search=p5_sfx_filter
    $url = "https://www.pond5.com/ajax/search/autocomplete?frag=" . $_PARAM_basic_keyword . "&lang=en_US&type=" . $_PARAM_media_type . "&search=" . $filter;
//echo $url;exit();
    $session = curl_init();
    curl_setopt($session, CURLOPT_URL, $url);
    curl_setopt($session, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($session, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/58.0.3029.97 Safari/537.36 Vivaldi/1.9.818.49');
    $pond5_response = curl_exec($session);
    unset($session);

    return $pond5_response;
}
