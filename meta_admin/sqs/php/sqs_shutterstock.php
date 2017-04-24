<?php error_reporting( - 1 );


if ( isset( $_POST["mtRadio"] ) ) {
    $mt = $_POST["mtRadio"];
} else {
    $mt = "image";
};


if ( isset( $_POST["kwString"] ) ) {
    $kwArr = prepare_query( $_POST["kwString"] );
    if ( count( $kwArr ) > 0 ) {
        for ( $i = 0; $i < count( $kwArr ); $i ++ ) {
            $json_data = get_hints( $kwArr[ $i ], $mt );
            json_parser( $json_data, $kwArr[ $i ] );
            if ( $i > 0 ) {
                sleep( 2 );
            }
        }
    } else {
        $json_data = get_hints( "", $mt );
        json_parser( $json_data, "" );
    }
} else {
    $json_data = get_hints( "", $mt );
    json_parser( $json_data, "" );
};


//ФУНКЦИИ


function prepare_query( $_PARAM_query ) {
    $kwArr = mb_strtolower( htmlspecialchars( strip_tags( stripslashes( $_PARAM_query ) ) ), "utf-8" );
    $kwArr = preg_replace( "/ {2,}/", " ", $kwArr );
    $kwArr = preg_split( "[\n|,|;]", $kwArr, - 1, PREG_SPLIT_NO_EMPTY );
    for ( $i = 0; $i < count( $kwArr ); $i ++ ) {
        $kwArr[ $i ] = trim( $kwArr[ $i ] );
    }
    $kwArr = array_values( array_unique( ( array_diff( $kwArr, array( '' ) ) ) ) );

    return $kwArr;
}

;


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
    $json_data = curl_exec( $ses );
    curl_close( $ses );

    return $json_data;
}

;


function json_parser( $_PARAM_json_data, $_PARAM_kw ) {
    $formated_data = json_decode( $_PARAM_json_data, true );
    $formated_data = $formated_data["data"]["autocompletions"];
    if ( isset( $formated_data ) && count( $formated_data ) > 0 ) {
        $rulesArr = [
            " and ",
            " at ",
            " in ",
            " on ",
            " of "
        ];
        for ( $i = 0; $i < count( $formated_data ); $i ++ ) {
            $f = true;
            for ( $j = 0; $j < count( $rulesArr ); $j ++ ) {
                if ( strpos( $formated_data[ $i ]["pattern"], $rulesArr[ $j ] ) === false ) {
                    continue;
                } else {
                    $f = false;
                    break;
                }
            }
            if ( $f === true ) {
                //TODO: А если вырежет в середине ответа?
                $formated_data[ $i ]["pattern"] = str_replace( $_PARAM_kw . " ", "", $formated_data[ $i ]["pattern"] );
            }
            $formated_data[ $i ] = $formated_data[ $i ]["pattern"] . " - " . $formated_data[ $i ]["probability"];
        }
        $formated_data = implode( "\n", $formated_data );
        echo( "<pre>" . $formated_data . "</pre>" );
    } else {
        echo( "Подсказок нет." );
    };
}

;