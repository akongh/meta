<?php

declare(strict_types=1);
error_reporting(-1);

$get_data = file_get_contents("php://input");
$get_data_to_array = json_decode($get_data, true);

$basic_keywords_string = $get_data_to_array[0];
$data_width = 524288;

if (iconv_strlen($basic_keywords_string, 'utf-8') > $data_width) {
    //зачем я тут сохранил в переменную подстроку? Может на всякий случай, чтобы потом её вывести обрезанную, если буду переделывать логику?
    $basic_keywords_string = mb_substr($basic_keywords_string, 0, $data_width, 'utf-8');
    echo("err_1");
    exit;
}

if ("" === trim($basic_keywords_string)) {
    echo("err_2");
    exit;
}

$basic_keywords_string = preg_replace(["/ {2,}/u"], [" "], $basic_keywords_string);
$basic_keywords_string = mb_strtolower($basic_keywords_string);
$basic_keywords_array = preg_split("/[\n,;]/u", $basic_keywords_string, -1, PREG_SPLIT_NO_EMPTY);
if ("false" === $get_data_to_array[1]) {
    foreach ($basic_keywords_array as &$value) {
        $value = trim($value);
        unset($value);
    }
}
$basic_keywords_array = array_values(array_unique(array_diff($basic_keywords_array, array(""))));

if (count($basic_keywords_array) > 20480) {
    echo("err_3");
    exit;
}

if ("false" === $get_data_to_array[2]) {
    foreach ($basic_keywords_array as $value) {
        if (!preg_match("/^[а-яёa-z0-9 \-'&#]*$/u", $value)) {
            echo("err_4" . $value);
            exit;
        }
    }
}

$result_array = array();
foreach ($basic_keywords_array as $element) {
    $result_array[] = [
        "hint" => $element
    ];
}

$json_result = json_encode($result_array, JSON_UNESCAPED_UNICODE);

echo($json_result);
