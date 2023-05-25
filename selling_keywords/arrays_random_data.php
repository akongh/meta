<?php

$array_useragents = [
    'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/58.0.3029.97 Safari/537.36 Vivaldi/1.9.818.49',
    'Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/58.0.3029.81 Safari/537.36 OPR/45.0.2552.812',
    'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/113.0'
];

$patch_to_selling_keywords_cookies = $_SERVER["DOCUMENT_ROOT"] . "/../_meta_privacy/selling_keywords_cookies";
if (file_exists($patch_to_selling_keywords_cookies)) {
    $array_cookies = file($patch_to_selling_keywords_cookies, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
} else {
    echo "Selling keywords sessions not found.";
    exit;
}

$array_countries = [
//    "AU",
//    "AT",
//    "AR",
//    "BE",
//    "BR",
//    "GB",
//    "DE",
//    "DK",
//    "IL",
//    "IE",
//    "ES",
//    "IT",
//    "CA",
//    "CN",
//    "NL",
//    "NO",
//    "AE",
//    "PL",
//    "RU",
    "US",
//    "TR",
//    "FR",
//    "CH",
//    "ZA",
//    "JP"
];
