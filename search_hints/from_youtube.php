<?php

declare(strict_types=1);
error_reporting(-1);

require_once($_SERVER["DOCUMENT_ROOT"] . "/search_hints/get_and_check.php");

if (false === strpos($basic_keywords_string, "*")) {
    $cp = strlen($basic_keywords_string);
} else {
    $cp = strpos($basic_keywords_string, "*") + 1;
}

if ("no_0-z" === $related_parameter) {
    $youtube_response = YOUTUBE_RESPONSE_FOR_ONE_BASIC_KEYWORD($basic_keywords_string, $cp);
    $clean_youtube_response = CLEANING_FOR_ONE_YOUTUBE_RESPONSE($youtube_response);

    if ("" === $clean_youtube_response) {
        echo("-3");
        exit;
    }

    $youtube_result = json_encode($clean_youtube_response, JSON_UNESCAPED_UNICODE);
} else if ("0-z" === $related_parameter) {
    $numeric_digits_array = ["0", "1", "2", "3", "4", "5", "6", "7", "8", "9"];
    $latin_script_array = ["a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k", "l", "m", "n", "o", "p", "q", "r", "s", "t", "u", "v", "w", "x", "y", "z"];
    $cyrillic_script_array = ["а", "б", "в", "г", "д", "е", "ё", "ж", "з", "и", "й", "к", "л", "м", "н", "о", "п", "р", "с", "т", "у", "ф", "х", "ц", "ч", "ш", "щ", "ъ", "ы", "ь", "э", "ю", "я"];
// todo: need add select character array
    $character_array = $latin_script_array;

    foreach ($character_array as $value) {
        $basic_keywords_string_character = $basic_keywords_string . $value;
        $youtube_response = YOUTUBE_RESPONSE_FOR_ONE_BASIC_KEYWORD($basic_keywords_string_character, $cp);
        $clean_youtube_response = CLEANING_FOR_ONE_YOUTUBE_RESPONSE($youtube_response);

        $a_z_hints_list[] = "---- " . mb_strtoupper($value) . " ----";

        if ("" !== $clean_youtube_response) {
            foreach ($clean_youtube_response as $value2) {
                $a_z_hints_list[] = $value2;
            }
            unset($value2);
        }
    }
    unset($value);

    $youtube_result = json_encode($a_z_hints_list, JSON_UNESCAPED_UNICODE);
} else {
    $youtube_result = "Not created \$youtube_result";
}

echo($youtube_result);


/**
 * Functions.
 */

/**
 * Создаёт youtube-ответ для одного ОКС.
 *
 * @param string $_PARAM_basic_keyword
 * @param int $_PARAM_cp
 * @return bool|string
 */
function YOUTUBE_RESPONSE_FOR_ONE_BASIC_KEYWORD(string $_PARAM_basic_keyword, int $_PARAM_cp)
{
    if ($_PARAM_basic_keyword != "") {
        $_PARAM_basic_keyword = preg_replace("/ /", "+", $_PARAM_basic_keyword);
    }
    $url = "https://suggestqueries-clients6.youtube.com/complete/search?" .
        "client=youtube" .
        "&hl=en" .
        "&gl=us" . // todo: need add select country option
        "&ds=yt" .
        "&cp=" . $_PARAM_cp .
        "&q=" . $_PARAM_basic_keyword .
        "&callback=callback";
    $sesion = curl_init();
    curl_setopt($sesion, CURLOPT_URL, $url);
    curl_setopt($sesion, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($sesion, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/58.0.3029.97 Safari/537.36 Vivaldi/1.9.818.49');
    $youtube_response = curl_exec($sesion);
    curl_close($sesion);

    return $youtube_response;
}

/**
 * Очищает от служебной информации массив подсказок для одного youtube-ответа.
 *
 * @param string $_PARAM_youtube_response
 * @return array | string
 */
function CLEANING_FOR_ONE_YOUTUBE_RESPONSE(string $_PARAM_youtube_response)
{
    $clean_youtube_response = preg_replace("/^callback && callback\(/", "", $_PARAM_youtube_response);
    $clean_youtube_response = preg_replace("/\)$/", "", $clean_youtube_response);

    $clean_youtube_response = json_decode($clean_youtube_response);

    if (NULL !== $clean_youtube_response) {
        foreach ($clean_youtube_response[1] as $value) {
            if (NULL !== $value) {
                $clean_youtube_response_array[] = $value[0];
            }
        }
        unset($value);
    }

    return $clean_youtube_response_array ?? "";
}
