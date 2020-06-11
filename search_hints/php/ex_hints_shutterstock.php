<?php

declare(strict_types=1);
error_reporting(-1);

//получаем и определяем параметр mediaType и строку ОКС
$media_type = $_POST["mediaType"];
$basic_keywords_string = $_POST["basicKeywordsString"];

$data_width = 64;
if (iconv_strlen($basic_keywords_string, 'utf-8') > $data_width) {
    $data_string = mb_substr($basic_keywords_string, 0, $data_width, 'utf-8');
    echo("-1");
    exit;
}

//получаем json-ответы для каждого ОКС
$json_responce = JSON_RESPONCE_FOR_ONE_BASIC_KEYWORD($basic_keywords_string, $media_type);

//очистка json-ответа от служебной информации
$clean_json_responce = CLEANING_FOR_ONE_JSON_RESPONCE($json_responce);//var_dump($clean_json_responce);exit;

//подготовка json-ответа
$json_result = json_encode($clean_json_responce, JSON_UNESCAPED_UNICODE);

echo($json_result);


/**
 * Functions.
 */

//создаёт json-ответ для одного ОКС
function JSON_RESPONCE_FOR_ONE_BASIC_KEYWORD($_PARAM_basic_keyword, $_PARAM_media_type)
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
    $json_responce = curl_exec($sesion);
    curl_close($sesion);

    return $json_responce;
}

//очищает от служебной информации массив подсказок для одного json-ответа
function CLEANING_FOR_ONE_JSON_RESPONCE($_PARAM_json_responce)
{
    $clean_json_responce = preg_replace("/ {2,}/", " ", $_PARAM_json_responce);
    $clean_json_responce = json_decode($clean_json_responce, true);
    $clean_json_responce = $clean_json_responce["data"]["autocompletions"];

    return $clean_json_responce;
}
