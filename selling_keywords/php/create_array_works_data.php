<?php error_reporting( - 1 );

if ( isset( $_POST['author'] ) ) {
    $author = trim( $_POST['author'] );
    if ( $author != '' ) {
        $author = preg_replace( '/ /', '+', $author );
    }
}

if ( isset( $_POST['keyword'] ) ) {
    $keyword = trim( $_POST['keyword'] );
    if ( $keyword != '' ) {
        $keyword = preg_replace( '/ /', '+', $keyword );
        $keyword = preg_replace( '/\\n/', '+', $keyword );
    }
}

$image_type = $_POST['imageType'];

//var_dump( $_POST['author'] );
//var_dump( $_POST['keyword'] );
//var_dump( $_POST['imageType'] );

//var_dump( $author );
//var_dump( $keyword );
//var_dump( $image_type );

$array_useragents = [
    'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/58.0.3029.97 Safari/537.36 Vivaldi/1.9.818.49',
    'Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/58.0.3029.81 Safari/537.36 OPR/45.0.2552.812'
];

require_once( $_SERVER["DOCUMENT_ROOT"] . "/selling_keywords/php/array_cookies.php" );

$useragent = RANDOM_SELECT_STRING( $array_useragents );
$cookies   = RANDOM_SELECT_STRING( $array_cookies );

if ( $author == '' ) {
    $search_url = 'https://www.shutterstock.com/en/search/' . $keyword . '?image_type=' . $image_type;

//    echo $search_url;

    $array_works_data = ARRAY_WORKS_DATA( $search_url, $useragent, $cookies );
} else {
    $search_url = 'https://www.shutterstock.com/g/' . $author . '?searchterm=' . $keyword . '&search_source=base_gallery&language=en&page=1&sort=popular&image_type=' . $image_type . '&measurement=px&safe=true';

//    echo $search_url;

    $array_works_data = ARRAY_WORKS_DATA( $search_url, $useragent, $cookies );
}

//echo $search_url;

//echo $array_works_data;

$url                    = CREATE_URL( $array_works_data );
$json_selling_keywords  = USE_CURL( $url, $useragent, $cookies );
//echo $json_selling_keywords;
$array_selling_keywords = json_decode( $json_selling_keywords, true );

for ( $i = 0; $i < count( $array_works_data ); $i ++ ) {
    for ( $j = 0; $i < count( $array_selling_keywords ); $j ++ ) {
        if ( (int) $array_works_data[ $i ]['id'] == (int) $array_selling_keywords[ $j ]['media_id'] ) {
            $array_works_data[ $i ]['keywords'] = $array_selling_keywords[ $j ]['keywords'];
            break;
        }
    }
}

echo( json_encode( $array_works_data ) );

/**
 * Functions.
 */

function RANDOM_SELECT_STRING( $_PARAM_array_strings ) {

    $max    = count( $_PARAM_array_strings ) - 1;
    $string = $_PARAM_array_strings[ rand( 0, $max ) ];

    return ( $string );
}

function ARRAY_WORKS_DATA( $_PARAM_url, $_PARAM_useragent, $_PARAM_cookies ) {

    $data = USE_CURL( $_PARAM_url, $_PARAM_useragent, $_PARAM_cookies );

//    echo $data;

    preg_match_all( '/(<img\ class="z_h_j z_h_a z_h_b").*?(>)/su', $data, $array_works_block );

//    var_dump( $array_works_block );
//    echo count( $array_works_block[0]);

    if ( count( $array_works_block[0] ) == 0 ) {
        echo( '-1' );
        exit;
    }

    $array_works_block = $array_works_block[0];

    for ( $i = 0; $i < count( $array_works_block ); $i ++ ) {

        preg_match( '/(alt=").*?(")/su', $array_works_block[ $i ], $title );
        $title = preg_replace( '/alt="/', '', $title );
        $title = preg_replace( '/"/', '', $title );

        $img = $array_works_block[ $i ];

        preg_match( "/[0-9]*.jpg/su", $array_works_block[ $i ], $id );
        $id = preg_replace( '/.jpg/', '', $id );

        $array_works_data[ $i ] = [
            'title' => $title[0],
            'img'   => $img,
            'id'    => $id[0]
        ];
    }

    return $array_works_data;
}

//function ARRAY_WORKS_DATA_AUTHOR( $_PARAM_url, $_PARAM_useragent, $_PARAM_cookies ) {
//
//    $data = USE_CURL( $_PARAM_url, $_PARAM_useragent, $_PARAM_cookies );
//
////    echo $data;
//
//    preg_match_all( '/(<li\ class="li js_item").*?(<\/li>)/su', $data, $array_works_block );
//
////    var_dump( $array_works_block );
////    echo count( $array_works_block[0]);
//
//    if ( count( $array_works_block[0] ) == 0 ) {
//        echo( '-1' );
//        exit;
//    }
//
//    $array_works_block = $array_works_block[0];
//
//    for ( $i = 0; $i < count( $array_works_block ); $i ++ ) {
//
//        preg_match( '/(alt=").*?(">)/su', $array_works_block[ $i ], $title );
//        $title = preg_replace( '/alt="/', '', $title );
//        $title = preg_replace( '/">/', '', $title );
//
//        preg_match( '/(<img\ src=").*?(">)/su', $array_works_block[ $i ], $img );
//
//        preg_match( '/(data-id=").*?(")/su', $array_works_block[ $i ], $id );
//        $id = preg_replace( '/data-id="/', '', $id );
//        $id = preg_replace( '/"/', '', $id );
//
//        $array_works_data[ $i ] = [
//            'title' => $title[0],
//            'img'   => $img[0],
//            'id'    => $id[0]
//        ];
//    }
//
//    return $array_works_data;
//}

function CREATE_URL( $_PARAM_array_works_ids ) {

    for ( $i = 0; $i < count( $_PARAM_array_works_ids ); $i ++ ) {
        $array_params[ $i ] = 'ids[]=' . $_PARAM_array_works_ids[ $i ]['id'];
    }

    $string_params = implode( '&', $array_params );
    $url           = 'https://submit.shutterstock.com/api/earnings/keywords?' . $string_params;

    return ( $url );
}

function USE_CURL( $_PARAM_url, $_PARAM_useragent, $_PARAM_cookies ) {

    $SESSION = curl_init();
    curl_setopt( $SESSION, CURLOPT_RETURNTRANSFER, true );
    curl_setopt( $SESSION, CURLOPT_URL, $_PARAM_url );
    curl_setopt( $SESSION, CURLOPT_USERAGENT, $_PARAM_useragent );
    curl_setopt( $SESSION, CURLOPT_COOKIE, $_PARAM_cookies );
    curl_setopt( $SESSION, CURLOPT_HTTPAUTH, CURLAUTH_BASIC );
    curl_setopt( $SESSION, CURLOPT_FOLLOWLOCATION, true );
    curl_setopt( $SESSION, CURLOPT_SSL_VERIFYHOST, false );
    curl_setopt( $SESSION, CURLOPT_SSL_VERIFYPEER, false );
    $result = curl_exec( $SESSION );

//    var_dump( curl_getinfo( $SESSION ) );
//    var_dump( curl_getinfo( $SESSION, CURLINFO_EFFECTIVE_URL ) );
//    var_dump( curl_getinfo( $SESSION, CURLINFO_REDIRECT_COUNT ) );

    curl_close( $SESSION );

    return ( $result );
}
