<?php

declare(strict_types=1);
error_reporting(-1);

if (isset($_POST['author'])) {
    $author = trim($_POST['author']);
    if ($author != '') {
        $author = preg_replace('/\s/', '+', $author);
    }
}

if (isset($_POST['keyword'])) {
    $keyword = trim($_POST['keyword']);
    if ($keyword != '') {
        $keyword = preg_replace('/\s/', '+', $keyword);
    }
}

$image_type = $_POST['imageType'];

require_once($_SERVER["DOCUMENT_ROOT"] . "/selling_keywords/arrays_cookies_agents.php");

$useragent = RANDOM_SELECT_STRING($array_useragents);
$cookies = RANDOM_SELECT_STRING($array_cookies);

if ($author == '') {
    $search_url = 'https://www.shutterstock.com/en/search/' . $keyword . '?image_type=' . $image_type;
    $array_works_data = ARRAY_WORKS_DATA_JSON($search_url, $useragent, $cookies);
} else {
    $search_url = 'https://www.shutterstock.com/g/' . $author . '?searchterm=' . $keyword . '&search_source=base_gallery&language=en&page=1&sort=popular&image_type=' . $image_type . '&measurement=px&safe=true';
    $array_works_data = ARRAY_WORKS_DATA_HTML($search_url, $useragent, $cookies);
}

$url = CREATE_URL($array_works_data);
$json_selling_keywords = USE_CURL($url, $useragent, $cookies);
$array_selling_keywords = json_decode($json_selling_keywords, true);

foreach ($array_works_data as $element_1) {
    foreach ($array_selling_keywords as $element_2) {
        if ((int)$element_1['id'] == (int)$element_2['media_id']) {
            $element_1['keywords'] = $element_2['keywords'];
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
function RANDOM_SELECT_STRING($_PARAM_array_strings)
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
function ARRAY_WORKS_DATA_HTML($_PARAM_url, $_PARAM_useragent, $_PARAM_cookies)
{
    $data = USE_CURL($_PARAM_url, $_PARAM_useragent, $_PARAM_cookies);
    preg_match_all('/<img class="z_h_l z_h_c z_h_e".*?>/su', $data, $array_works_block);

    if (count($array_works_block[0]) == 0) {
        echo('-1');
        exit;
    }

    $array_works_block = $array_works_block[0];
    $array_works_data = array();

    foreach ($array_works_block as $element) {
        preg_match('/alt=".*?"/su', $element, $title);
        $title = preg_replace('/alt="/', '', $title);
        $title = preg_replace('/"/', '', $title);
        $img = $element;

        preg_match("/[0-9]*\.jpg/su", $element, $id);
        $id = preg_replace('/\.jpg/', '', $id);

        $array_works_data[] = [
            'title' => $title[0],
            'img' => $img,
            'id' => $id[0]
        ];
    }

    return $array_works_data;
}

/**
 * @param string $_PARAM_url
 * @param string $_PARAM_useragent
 * @param string $_PARAM_cookies
 * @return array
 */
function ARRAY_WORKS_DATA_JSON($_PARAM_url, $_PARAM_useragent, $_PARAM_cookies)
{
    $data = USE_CURL($_PARAM_url, $_PARAM_useragent, $_PARAM_cookies);
    preg_match_all('/<script data-react-helmet="true" type="application\/ld\+json">\[.*]<\/script>/su', $data, $array_works_block);

    if (count($array_works_block[0]) == 0) {
        echo('-1');
        exit;
    }

    $array_works_block[0][0] = preg_replace('/<script data-react-helmet="true" type="application\/ld\+json">\[/', '', $array_works_block[0][0]);
    $array_works_block[0][0] = preg_replace('/]<\/script>/', '', $array_works_block[0][0]);
    $array_works_block[0][0] = preg_replace('/},{/', '},,,,{', $array_works_block[0][0]);
    $array_works_block = explode(",,,,", $array_works_block[0][0]);
    $array_works_data = array();

    foreach ($array_works_block as $element) {
        $array_works_json_decode = json_decode($element, true);
        preg_match("/[0-9]*$/su", $array_works_json_decode['name'], $id);
        $id = $id[0];
        $array_works_data[] = [
            'title' => $array_works_json_decode['name'],
            'img' => '<img src="' . $array_works_json_decode['thumbnail'] . '">',
            'id' => $id
        ];
    }

    return $array_works_data;
}

/**
 * @param array $_PARAM_array_works_ids
 * @return string
 */
function CREATE_URL($_PARAM_array_works_ids)
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
function USE_CURL($_PARAM_url, $_PARAM_useragent, $_PARAM_cookies)
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
