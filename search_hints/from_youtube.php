<?php

declare(strict_types=1);
error_reporting(-1);

$basic_keywords_string = mb_strtolower(file_get_contents("php://input"));
//var_dump($basic_keywords_string);
//exit;

$data_width = 64;
if (iconv_strlen($basic_keywords_string, 'utf-8') > $data_width) {
    echo("-1");
    exit;
}

if (!preg_match("/^[a-z0-9'& -]*$/u", $basic_keywords_string)) {
    echo("-2"); // A0 - ' & z9
    exit;
}

$youtube_response = YOUTUBE_RESPONSE_FOR_ONE_BASIC_KEYWORD($basic_keywords_string);
//var_dump($youtube_response);
//exit;
$clean_youtube_response = CLEANING_FOR_ONE_YOUTUBE_RESPONSE($youtube_response);
//var_dump($clean_youtube_response);
//exit;
$result = json_encode($clean_youtube_response, JSON_UNESCAPED_UNICODE);

echo($result);


/**
 * Functions.
 */

/**
 * Создаёт youtube-ответ для одного ОКС.
 *
 * @param string $_PARAM_basic_keyword
 * @return bool|string
 */
function YOUTUBE_RESPONSE_FOR_ONE_BASIC_KEYWORD(string $_PARAM_basic_keyword)
{
    if ($_PARAM_basic_keyword != "") {
        $_PARAM_basic_keyword = preg_replace("/ /", "+", $_PARAM_basic_keyword);
    }
    $url="https://suggestqueries-clients6.youtube.com/complete/search?client=youtube&hl=en&gl=us&sugexp=qszpp,ytpo.bo.me=1,ytposo.bo.me=1,cfro=1,ytpo.bo.me=0,ytposo.bo.me=0,ytpo.bo.zo.mq=15,ytpo.bo.zo.ms=0,ytposo.bo.zo.mq=15,ytposo.bo.zo.ms=0&gs_rn=64&gs_ri=youtube&tok=qwer0000&ds=yt&cp=3&gs_id=k&q=". $_PARAM_basic_keyword . "&callback=google.sbox.p50&gs_gbg=qwer0000";
//    var_dump($url);
//    exit;
    $sesion = curl_init();
    curl_setopt($sesion, CURLOPT_URL, $url);
    curl_setopt($sesion, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($sesion, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/58.0.3029.97 Safari/537.36 Vivaldi/1.9.818.49');
    $youtube_response = curl_exec($sesion);
//    var_dump($youtube_response);
//    exit;
    curl_close($sesion);

    return $youtube_response;
}

/**
 * Очищает от служебной информации массив подсказок для одного youtube-ответа.
 *
 * @param string $_PARAM_youtube_response
 * @return string
 */
function CLEANING_FOR_ONE_YOUTUBE_RESPONSE(string $_PARAM_youtube_response): string
{
    $clean_youtube_response = preg_replace("/google\.sbox\.p50 && google\.sbox\.p50\(/", "", $_PARAM_youtube_response);
    $clean_youtube_response = preg_replace("/\)/", "", $clean_youtube_response);
    $clean_youtube_response = preg_replace("/{.+}/", "", $clean_youtube_response);
    $clean_youtube_response = json_decode($clean_youtube_response, true);

    return $clean_youtube_response["data"]["autocompletions"];
}
