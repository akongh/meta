<?php error_reporting( - 1 );


if ( isset( $_POST["mtRadio"] ) ) {
    $mt = $_POST["mtRadio"];
} else {
    $mt = "image";
};


if ( isset( $_POST["kwString"] ) ) {
    $kwArr = mb_strtolower( htmlspecialchars( strip_tags( stripslashes( $_POST["kwString"] ) ) ), "utf-8" );
    $kwArr = preg_replace( "/ {2,}/", " ", $kwArr );
    $kwArr = preg_split( "[\n|,|;]", $kwArr, - 1, PREG_SPLIT_NO_EMPTY );
    for ( $i = 0; $i < count( $kwArr ); $i ++ ) {
        $kwArr[ $i ] = trim( $kwArr[ $i ] );
    }
    $kwArr = array_values( array_unique( ( array_diff( $kwArr, array( '' ) ) ) ) );
    if ( count( $kwArr ) > 0 ) {
        for ( $i = 0; $i < count( $kwArr ); $i ++ ) {
            get_hints( $kwArr[ $i ], $mt );
            if ( $i > 0 ) {
                sleep( 2 );
            }
        }
    } else {
        get_hints( "", $mt );
    }
} else {
    get_hints( "", $mt );
};


function get_hints( $_PARAM_kw_query, $_PARAM_mt ) {
    if ( $_PARAM_kw_query != "" ) {
        $_PARAM_kw_query = preg_replace( "/ /", "+", $_PARAM_kw_query );
    };
    $anticache_time = time();
    $anticache_num  = rand( 100, 999 );
    $anticache_id   = $anticache_time . $anticache_num;
    //TODO: Возможно, имеет смысл подменить другие данные (о клиенте и т. д.), которые передаются или наоборот, добавить, чтоб не было видно, что запросы с сервера.
    $url = "https://www.shutterstock.com/api/autocomplete?q=" . $_PARAM_kw_query . "&mediaType=" . $_PARAM_mt . "&_=" . $anticache_id;
    $ses = curl_init();
    curl_setopt( $ses, CURLOPT_URL, $url );
    curl_setopt( $ses, CURLOPT_RETURNTRANSFER, true );
    $data = curl_exec( $ses );
    curl_close( $ses );

    echo( $data );
}

;