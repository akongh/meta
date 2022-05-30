<?php

declare(strict_types=1);
error_reporting(-1);

require($_SERVER["DOCUMENT_ROOT"] . '/_meta_privacy_db_connection.php');

$keyword_in_russian = $_POST["keywordInRussian"];

$keyword_in_russian = PREPARE_KEYWORD_IN_RUSSIAN_FOR_TRANLATION($keyword_in_russian);

if ($keyword_in_russian == "") {
    echo("-2");
    exit;
}

if (!preg_match("/^[а-яё0-9 -]*$/u", $keyword_in_russian)) {
    echo("-3");
    exit;
}

$translations_array = SEARCH_TRANLATIONS($mysqli, $keyword_in_russian);

mysqli_close($mysqli);

if ($translations_array == "-1") {
    echo("-1");
    exit;
}

$json_result = json_encode($translations_array, JSON_UNESCAPED_UNICODE);

echo $json_result;


/**
 * Functions.
 */

/**
 * Проверяет, чистит и правит полученное ОКС.
 * @param string $PARAM_keyword_in_russian
 * @return string
 */
function PREPARE_KEYWORD_IN_RUSSIAN_FOR_TRANLATION(string $PARAM_keyword_in_russian): string
{
    $keyword_in_russian = mb_strtolower(preg_replace(["/ {2,}/u", "/-{2,}/u", "/ -/u", "/- /u"], [" ", "-", "-", "-"], $PARAM_keyword_in_russian));
    return trim(trim($keyword_in_russian), "-");
}

/**
 * Ищет в базе переводы.
 * @param mysqli $PARAM_db_connect
 * @param string $PARAM_keyword_in_russian
 * @return array|string
 */
function SEARCH_TRANLATIONS(mysqli $PARAM_db_connect, string $PARAM_keyword_in_russian)
{
    $SQL_select_translations_and_sense = mysqli_query($PARAM_db_connect, "
	select `l-ts`.`s`, `tz`.`z`
	from `k-ts`
	join `k_l` on `k-ts`.`ids`=`k_l`.`idk`
	join `l-ts` on `l-ts`.`ids`=`k_l`.`idl`
	join `tz` on `tz`.`idz`=`k_l`.`idz`
	where `k-ts`.`s`='" . $PARAM_keyword_in_russian . "'
	");

    $n = 0;
    while ($result = mysqli_fetch_array($SQL_select_translations_and_sense)) {
        $translation[$n] = $result["s"];
        $sense[$n] = $result["z"];
        $translations_array[$n] = "<span class='hover-invert'>" . $translation[$n] . "</span> - " . $sense[$n] . "<br>";
        $n++;
    }

    if (isset($translations_array) && count($translations_array) > 0) {
        return $translations_array;
    } else {
        return "-1";
    }
}
