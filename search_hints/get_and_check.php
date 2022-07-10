<?php

declare(strict_types=1);
error_reporting(-1);

$php_input_to_array = explode("\n", mb_strtolower(file_get_contents("php://input")));
$related_parameter = $php_input_to_array[0];
$basic_keywords_string = $php_input_to_array[1];
if (isset($php_input_to_array[2])) {
    $param0_z = $php_input_to_array[2];
}
$excluded_keywords_array = [];

if (isset($php_input_to_array[2]) && "" !== trim($php_input_to_array[2])) {
    $excluded_keywords_array = explode(",", $php_input_to_array[2]);

    foreach ($excluded_keywords_array as $key => $value) {
        $excluded_keywords_array[$key] = preg_replace("/ {2,}/u", " ", $value);
        if ("" == $excluded_keywords_array[$key]) {
            unset($excluded_keywords_array[$key]);
        }
    }
    unset($value);

    $excluded_keywords_array = array_values(array_unique($excluded_keywords_array));
}

$data_width = 40;
if (iconv_strlen($basic_keywords_string, 'utf-8') > $data_width) {
    echo("-1");
    exit;
}

if (!preg_match("/^[а-яёa-z0-9 \-'&_]*$/u", $basic_keywords_string)) {
    echo("-2");
    exit;
} //only for lower case
