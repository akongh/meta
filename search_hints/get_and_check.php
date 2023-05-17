<?php

declare(strict_types=1);
error_reporting(-1);

$php_input_to_array = explode("\n", mb_strtolower(file_get_contents("php://input")));
$basic_keywords_string = $php_input_to_array[0];
$related_parameter = $php_input_to_array[1];
$related_parameter_2 = $php_input_to_array[2];
$related_parameter_3 = $php_input_to_array[3];

$data_width = 40;
if (iconv_strlen($basic_keywords_string, 'utf-8') > $data_width) {
    echo("-1");
    exit;
}

if (!preg_match("/^[а-яёa-zäößü0-9 \-'&_*]*$/u", $basic_keywords_string)) {
    echo("-2");
    exit;
} //only for lower case after mb_strtolower()

if ("" === trim($basic_keywords_string)) {
    echo("-3");
    exit;
}
