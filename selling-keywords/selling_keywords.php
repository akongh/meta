<?php


if ( isset( $_POST['autor'] ) && $_POST['autor'] != '' ) {
    $autor = $_POST['autor'];
    $autor = preg_replace( '/ /', '+', $autor );
} else {
    $autor = '';
};
if ( isset( $_POST['keyword'] ) && $_POST['keyword'] != '' ) {
    $keyword = $_POST['keyword'];
    $keyword = preg_replace( '/ /', '+', $keyword );
} else if ( ( ! isset( $_POST['keyword'] ) || $_POST['keyword'] == '' ) && ( isset( $_POST['autor'] ) && $_POST['autor'] != '' ) ) {
    $keyword = '';
} else {
    echo( '-1' );
    exit;
};
$image_type = $_POST['imageType'];


$array_works_data = ARRAY_WORKS_DATA( $autor, $keyword, $image_type );
//echo( $array_works_data );

$array_useragents = [
    'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/58.0.3029.97 Safari/537.36 Vivaldi/1.9.818.49',
    'Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/58.0.3029.81 Safari/537.36 OPR/45.0.2552.812'
];

$array_cookies = [
    'session=s%3A7CJaAyGtNvqfKoSHbbt4DdbvnrZ8-4YS.DzP343XRqh7rDPT1T1bIFM4hwZDStgJoNnFktdETfl8',
    'session=s%3Admjt3A_VbcA77InELTfFXlyXJNSIztLL.KIG0okZoFU3nUZCMM8T4uNzX%2F73JDZL15tINWvui8vU'
];


$url                    = CREATE_URL( $array_works_data );
$useragent              = RANDOM_SELECT_USERAGENT( $array_useragents );
$cookies                = RANDOM_SELECT_COOKIES( $array_cookies );
$json_selling_keywords  = GET_JSON_SELLING_KEYWORDS( $url, $useragent, $cookies );
$array_selling_keywords = json_decode( $json_selling_keywords, true );


for ( $i = 0; $i < count( $array_works_data ); $i ++ ) {
    for ( $j = 0; $i < count( $array_selling_keywords ); $j ++ ) {
        if ( (int) $array_works_data[ $i ]['id'] == (int) $array_selling_keywords[ $j ]['media_id'] ) {
            $array_works_data[ $i ]['keywords'] = $array_selling_keywords[ $j ]['keywords'];
            break;
        };
    };
};


echo( json_encode( $array_works_data ) );


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// ФУНКЦИИ /////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function ARRAY_WORKS_DATA( $_PARAM_autor, $_PARAM_keyword, $_PARAM_image_type ) {

    if ( $_PARAM_autor == '' ) {
        $search_url = 'https://www.shutterstock.com/search?searchterm=' . $_PARAM_keyword . '&image_type=' . $_PARAM_image_type . '&search_source=base_landing_page&language=en&page=1';
    } else {
        $search_url = 'https://www.shutterstock.com/g/' . $_PARAM_autor . '?searchterm=' . $_PARAM_keyword . '&image_type=' . $_PARAM_image_type . '&search_source=base_gallery&language=en&sort=popular&safe=true';
//        $search_url = 'https://www.shutterstock.com/g/' . $_PARAM_autor . '?search_source=base_gallery&language=en&sort=popular&safe=true';
    };
    $data = file_get_contents( $search_url );

    preg_match_all( '/(<li\ class="li js_item").*?(<\/li>)/su', $data, $array_works_block );
    if ( count( $array_works_block[0] ) == 0 ) {
        echo( '-1' );
        exit;
    };

    $array_works_block = $array_works_block[0];

    for ( $i = 0; $i < count( $array_works_block ); $i ++ ) {

        preg_match( "/(alt=\").*?(\">)/su", $array_works_block[ $i ], $title );
        $title = preg_replace( '/alt="/', '', $title );
        $title = preg_replace( '/">/', '', $title );

        preg_match( "/(<img\ src=\").*?(\">)/su", $array_works_block[ $i ], $img );

        preg_match( "/(data-id=\").*?(\")/su", $array_works_block[ $i ], $id );
        $id = preg_replace( '/data-id="/', '', $id );
        $id = preg_replace( '/"/', '', $id );

        $array_works_data[ $i ] = [
            'title' => $title[0],
            'img'   => $img[0],
            'id'    => $id[0]
        ];
    };

    return $array_works_data;
}

;


function CREATE_URL( $_PARAM_array_works_ids ) {

    for ( $i = 0; $i < count( $_PARAM_array_works_ids ); $i ++ ) {
        $array_params[ $i ] = 'ids[]=' . $_PARAM_array_works_ids[ $i ]['id'];
    };
    $string_params = implode( '&', $array_params );
    $url           = 'https://submit.shutterstock.com/api/earnings/keywords?' . $string_params;

    return ( $url );
}

;


function RANDOM_SELECT_USERAGENT( $_PARAM_array_useragents ) {

    $max       = count( $_PARAM_array_useragents ) - 1;
    $useragent = $_PARAM_array_useragents[ rand( 0, $max ) ];

    return ( $useragent );
}

;


function RANDOM_SELECT_COOKIES( $_PARAM_array_cookies ) {

    $max     = count( $_PARAM_array_cookies ) - 1;
    $cookies = $_PARAM_array_cookies[ rand( 0, $max ) ];

    return ( $cookies );
}

;


function GET_JSON_SELLING_KEYWORDS( $_PARAM_url, $_PARAM_useragent, $_PARAM_cookies ) {

    $SESSION = curl_init();
    curl_setopt( $SESSION, CURLOPT_RETURNTRANSFER, true );
    curl_setopt( $SESSION, CURLOPT_URL, $_PARAM_url );
    curl_setopt( $SESSION, CURLOPT_USERAGENT, $_PARAM_useragent );
    curl_setopt( $SESSION, CURLOPT_COOKIE, $_PARAM_cookies );
    $json_selling_keywords = curl_exec( $SESSION );
    curl_close( $SESSION );

    return ( $json_selling_keywords );
}

;