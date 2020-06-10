<?php

declare(strict_types=1);
error_reporting(-1);

require($_SERVER["DOCUMENT_ROOT"] . '/_privacy_path.php');

$basic_keywords_string = file_get_contents("php://input");
$data_width = 12288;

if (iconv_strlen($basic_keywords_string, 'utf-8') > $data_width) {
    $basic_keywords_string = mb_substr($basic_keywords_string, 0, $data_width, 'utf-8');
    echo("err_1");
    exit;
}

if ("" === trim($basic_keywords_string)) {
    echo("err_2");
    exit;
}

$basic_keywords_string = mb_strtolower(preg_replace(["/ {2,}/u"], [" "], $basic_keywords_string));
$basic_keywords_array = preg_split("/[\n,;]/u", $basic_keywords_string, -1, PREG_SPLIT_NO_EMPTY);
foreach ($basic_keywords_array as &$value) {
    $value = trim($value);
    unset($value);
}
$basic_keywords_array = array_values(array_unique(array_diff($basic_keywords_array, array(""))));

if (count($basic_keywords_array) > 384) {
    echo("err_3");
    exit;
}

foreach ($basic_keywords_array as $value) {
    if (!preg_match("/^[a-z0-9'& -]*$/u", $value)) {
        echo("err_4"); // A0 - ' & z9
        exit;
    }
}

$result_array = array();
foreach ($basic_keywords_array as $element) {
    $result_array[] = [
        "hint" => $element,
        "translation" => SELECT_TRANSLATION($element, $mysqli)
    ];
}

mysqli_close($mysqli);

$json_result = json_encode($result_array, JSON_UNESCAPED_UNICODE);

echo($json_result);


/**
 * Functions.
 */

/**
 * Выбирает перевод для одного слова.
 * @param string $_PARAM_hint_keyword
 * @param mysqli $_PARAM_db_connect
 * @return array
 */
function SELECT_TRANSLATION($_PARAM_hint_keyword, $_PARAM_db_connect)
{
    $_SQL_select_translations = "
SELECT
    `tz`.`z`
FROM
    `tz`
        JOIN
    `k_l` ON `tz`.`idz` = `k_l`.`idz`
        JOIN
    `l-ts` ON `k_l`.`idl` = `l-ts`.`ids`
WHERE
    `l-ts`.`s` = '" . mysqli_real_escape_string($_PARAM_db_connect, $_PARAM_hint_keyword) . "';
    ";

    $_SQL_translations = mysqli_query($_PARAM_db_connect, $_SQL_select_translations);

    $translations_array = array();

    if (0 === $_SQL_translations->num_rows) {
        $translations_array[] = "-";
    } else {
        while ($data = mysqli_fetch_array($_SQL_translations)) {
            $translations_array[] = $data["z"];
        }
    }

    return $translations_array;
}
