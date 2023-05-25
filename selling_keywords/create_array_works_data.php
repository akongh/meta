<?php

declare(strict_types=1);
error_reporting(-1);

require_once($_SERVER["DOCUMENT_ROOT"] . "/selling_keywords/arrays_random_data.php");

if (isset($_POST['author']) and "" !== $_POST['author']) {
    $author = preg_replace('/\s/', '+', $_POST['author']);
} else {
    $author = "";
}

if (isset($_POST['keyword']) and "" !== $_POST['keyword']) {
    $keyword = preg_replace('/\s/', '+', $_POST['keyword']);
} else {
    $keyword = "";
}

// $country = RANDOM_SELECT_STRING($array_countries);

if ("all" == $_POST['imageType']) {
    $image_type = "";
} else {
    $image_type = "image_type={$_POST['imageType']}&";
}

$useragent = RANDOM_SELECT_STRING($array_useragents);
$cookies = RANDOM_SELECT_STRING($array_cookies);

if ($author == '') {
    $author_id = "";
} else {
    // https://www.shutterstock.com/_next/data/ /en/_shutterstock/g/GatotAdri.json?portfolio-url-suffix=GatotAdri&q=concept
    $url = "https://www.shutterstock.com/studioapi/contributors?filter%5Bdisplay_name%5D=$author&include=contributor-stats";
    $author_info = USE_CURL($url, $useragent, $cookies);
    $author_info = json_decode($author_info, true);
    $author_id = "&filter%5Bsubmitter%5D={$author_info["data"][0]["id"]}";
}

$search_url = implode("", [
    "https://www.shutterstock.com/_next/data/ /en/_shutterstock/search/$keyword.json?",
    "$image_type",
    "term=$keyword"
]);

$array_works_data = ARRAY_WORKS_DATA_JSON($search_url, $useragent, $cookies);
$url = CREATE_URL($array_works_data);
$json_selling_keywords = USE_CURL($url, $useragent, $cookies);
file_put_contents('json_selling_keywords.json', $json_selling_keywords);
$array_selling_keywords = json_decode($json_selling_keywords, true);
file_put_contents('array_selling_keywords.json', json_encode($array_selling_keywords));

foreach ($array_works_data as &$element_1) {
    foreach ($array_selling_keywords as $element_2) {
        if ((int)$element_1['id'] == (int)$element_2['media_id']) {
            $element_1['keywords'] = $element_2['keywords'];
            unset($element_1);
            break;
        }
    }
}

echo(json_encode($array_works_data));


/**
 * Functions.
 */

/**
 * @param array $_PARAM_array_strings
 * @return string
 */
function RANDOM_SELECT_STRING(array $_PARAM_array_strings): string
{
    $max = count($_PARAM_array_strings) - 1;
    $string = $_PARAM_array_strings[rand(0, $max)];

    return ($string);
}

/**
 * @param string $_PARAM_url
 * @param string $_PARAM_useragent
 * @param string $_PARAM_cookies
 * @return array
 */
function ARRAY_WORKS_DATA_JSON(string $_PARAM_url, string $_PARAM_useragent, string $_PARAM_cookies): array
{
    $data = USE_CURL($_PARAM_url, $_PARAM_useragent, $_PARAM_cookies);
    if (false === $data) {
        echo('-2');
        exit;
    }
    file_put_contents('responce_data_from_shutterstock.json', $data);
    $array_works_block = json_decode($data, true){"pageProps"}["assets"];

    if (count($array_works_block) == 0) {
        echo('-1');
        exit;
    }

    $array_works_data = array();

    foreach ($array_works_block as $element) {
        $array_works_data[] = [
            'id' => $element['id'],
            'title' => $element["title"],
            'img' => '<img src="' . $element["src"] . '">',
            "link" => $element["link"]
        ];
    }

    file_put_contents('array_works_data.json', json_encode($array_works_data));

    return $array_works_data;
}

/**
 * @param array $_PARAM_array_works_ids
 * @return string
 */
function CREATE_URL(array $_PARAM_array_works_ids): string
{
    $array_params = array();

    foreach ($_PARAM_array_works_ids as $element) {
        $array_params[] = 'ids[]=' . $element['id'];
    }

    $string_params = implode('&', $array_params);
    $url = 'https://submit.shutterstock.com/api/earnings/keywords?' . $string_params;

    return ($url);
}

/**
 * @param string $_PARAM_url
 * @param string $_PARAM_useragent
 * @param string $_PARAM_cookies
 * @return bool|string
 */
function USE_CURL(string $_PARAM_url, string $_PARAM_useragent, string $_PARAM_cookies)
{
    $SESSION = curl_init();
    curl_setopt($SESSION, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($SESSION, CURLOPT_URL, $_PARAM_url);
    curl_setopt($SESSION, CURLOPT_USERAGENT, $_PARAM_useragent);
    curl_setopt($SESSION, CURLOPT_COOKIE, $_PARAM_cookies);
    curl_setopt($SESSION, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
    curl_setopt($SESSION, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($SESSION, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($SESSION, CURLOPT_SSL_VERIFYPEER, false);
    $result = curl_exec($SESSION);

    curl_close($SESSION);

    return ($result);
}
