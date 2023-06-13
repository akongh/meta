<?php

declare(strict_types=1);
error_reporting(-1);

require_once($_SERVER["DOCUMENT_ROOT"] . "/search_hints/get_and_check.php");

if (!str_contains($basic_keywords_string, "*")) {
    $cp = strlen($basic_keywords_string);
} else {
    $cp = strpos($basic_keywords_string, "*") + 1;
}

if ("no" === $related_parameter) {
    $youtube_response = YOUTUBE_RESPONSE_FOR_ONE_BASIC_KEYWORD($basic_keywords_string, $cp, $related_parameter_2, $related_parameter_3);
    $clean_youtube_response = CLEANING_FOR_ONE_YOUTUBE_RESPONSE($youtube_response);

    if ("" === $clean_youtube_response) {
        echo("-3");
        exit;
    }

    $youtube_result = json_encode($clean_youtube_response, JSON_UNESCAPED_UNICODE);
} else {
    $latin_script_array = ["a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k", "l", "m", "n", "o", "p", "q", "r", "s", "t", "u", "v", "w", "x", "y", "z"];
    $umlaut_ligature_array = ["ä", "ö", "ß", "ü"];
    $cyrillic_script_array = ["а", "б", "в", "г", "д", "е", "ё", "ж", "з", "и", "й", "к", "л", "м", "н", "о", "п", "р", "с", "т", "у", "ф", "х", "ц", "ч", "ш", "щ", "ъ", "ы", "ь", "э", "ю", "я"];
    $numeric_digits_array = ["0", "1", "2", "3", "4", "5", "6", "7", "8", "9"];
    $basic_words_for_tags = ["asmr", "at", "cook", "cooking", "easy", "exotic", "expensive", "famous", "food", "for", "from", "hack", "home", "homemade", "how", "idea", "ideas", "in", "ingredients", "make", "making", "meal", "most", "new", "no", "no cook", "no talking", "options", "popular", "quick", "recipe", "simple", "types", "ugly", "using", "video", "vlog", "way", "with", "without"];

    switch ($related_parameter) {
        case "latin":
        case "latin2":
            $character_array = $latin_script_array;
            break;
        case "umlaut_ligature":
            $character_array = $umlaut_ligature_array;
            break;
        case "cyrillic":
            $character_array = $cyrillic_script_array;
            break;
        case "digits":
            $character_array = $numeric_digits_array;
            break;
        case "words":
            $character_array = $basic_words_for_tags;
            break;
    }

    foreach ($character_array as $value) {
        $basic_keywords_string_character = $basic_keywords_string . $value;
        $youtube_response = YOUTUBE_RESPONSE_FOR_ONE_BASIC_KEYWORD($basic_keywords_string_character, $cp, $related_parameter_2, $related_parameter_3);
        $clean_youtube_response = CLEANING_FOR_ONE_YOUTUBE_RESPONSE($youtube_response);

        $search_suggestions_list[] = "____ " . mb_strtoupper($value) . " ____";

        if ("" !== $clean_youtube_response) {
            foreach ($clean_youtube_response as $value2) {
                $search_suggestions_list[] = $value2;
            }
            unset($value2);
        }
    }
    unset($value);

    if ("latin2" === $related_parameter) {
        $character_array_2 = $character_array;

        foreach ($character_array as $value) {
            foreach ($character_array_2 as $value2) {
                $basic_keywords_string_character = $basic_keywords_string . $value . $value2;
                $youtube_response = YOUTUBE_RESPONSE_FOR_ONE_BASIC_KEYWORD($basic_keywords_string_character, $cp, $related_parameter_2, $related_parameter_3);
                $clean_youtube_response = CLEANING_FOR_ONE_YOUTUBE_RESPONSE($youtube_response);

                $search_suggestions_list[] = "____ " . mb_strtoupper($value . $value2) . " ____";

                if ("" !== $clean_youtube_response) {
                    foreach ($clean_youtube_response as $value3) {
                        $search_suggestions_list[] = $value3;
                    }
                    unset($value3);
                }
            }
            unset($value2);
        }
        unset($value);
    }


    $youtube_result = json_encode($search_suggestions_list, JSON_UNESCAPED_UNICODE);
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
 * @param string $_PARAM_hl
 * @param string $_PARAM_gl
 * @return bool|string
 */
function YOUTUBE_RESPONSE_FOR_ONE_BASIC_KEYWORD(string $_PARAM_basic_keyword, int $_PARAM_cp, string $_PARAM_hl, string $_PARAM_gl): bool|string
{
    if ($_PARAM_basic_keyword != "") {
        $_PARAM_basic_keyword = preg_replace("/ /", "+", $_PARAM_basic_keyword);
    }
    $url = "https://suggestqueries-clients6.youtube.com/complete/search?" .
        "client=youtube" .
        "&hl=" . $_PARAM_hl .
        "&gl=" . $_PARAM_gl .
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
function CLEANING_FOR_ONE_YOUTUBE_RESPONSE(string $_PARAM_youtube_response): array|string
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
