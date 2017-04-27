<?php error_reporting( - 1 );

include( $_SERVER['DOCUMENT_ROOT'] . '/meta_config_db.php' );


//получаем и определяем параметр mediaType и строку ОКС
$media_type            = $_POST["mediaType"];
$basic_keywords_string = $_POST["basicKeywordsString"];


//готовим для запросов массив ОКС из строки ОКС
$basic_keywords_array = PREPARE_BASIC_KEYWORDS_ARRAY( $basic_keywords_string );


//проверка колличества ОКС
if ( count( $basic_keywords_array ) > 16 ) {
    echo( "Не более 8-ми опорных ключевых слов." );
    exit;
};


//подстроки для правила удаления ОКС из подсказки
$rules = [
    " about ",
    " above ",
    " across ",
    " after ",
    " against ",
    " along ",
    " among ",
    " and ",
    " around ",
    " as ",
    " at ",
    " before ",
    " behind ",
    " below ",
    " beside ",
    " between ",
    " beyond ",
    " by ",
    " during ",
    " for ",
    " from ",
    " how ",
    " in ",
    " in front of ",
    " inside ",
    " into ",
    " like ",
    " of ",
    " off ",
    " on ",
    " or ",
    " out ",
    " out of ",
    " outside ",
    " over ",
    " since ",
    " through ",
    " till ",
    " to ",
    " toward ",
    " under ",
    " until ",
    " up ",
    " via ",
    " when ",
    " while ",
    " with ",
    " within ",
    " without "
];


//получаем json-ответы для каждого ОКС
for ( $i = 0; $i < count( $basic_keywords_array ); $i ++ ) {
    $json_responce_array[ $i ] = JSON_RESPONCE_FOR_ONE_BASIC_KEYWORD( $basic_keywords_array[ $i ], $media_type );

    //очистка json-ответа от служебной информации
    $clean_json_responce_array[ $i ] = CLEANING_FOR_ONE_JSON_RESPONCE( $json_responce_array[ $i ] );

    //поднимаем на один уроввень мерность с шаблоном и вероятностью, оставляя только шаблон
    for ( $j = 0; $j < count( $clean_json_responce_array[ $i ] ); $j ++ ) {

        //на всякий случай чистим края
        $only_pattern_array[ $i ][ $j ] = trim( $clean_json_responce_array[ $i ][ $j ]["pattern"] );

        //удаляем ОКС из подсказок, если ОКС вначале подсказки и подскажка не имеет союзов и предлогов
        //TODO: если в ОКС есть предлог или союз, то это ОКС удаляться из подсказки не будет
        $current_pattern = $only_pattern_array[ $i ][ $j ];
        $current_keyword = $basic_keywords_array[ $i ];
        $f               = true;//флаг обнаружения правила в подсказке
        for ( $k = 0; $k < count( $rules ); $k ++ ) {
            if ( strpos( $current_pattern, $rules[ $k ] ) === false ) {
                continue;
            } else {
                $f = false;
                break;
            }
        };
        if ( $f === true ) {
            $hint_keyword_array[ $i ][ $j ] = DELETE_BASIC_KEYWORD_FROM_HINT( $current_keyword, $current_pattern );
        } else {
            $hint_keyword_array[ $i ][ $j ] = $current_pattern;
        };
        $hint_keyword_array_full[ $i ][ $j ] = $current_pattern;
    };

    //спим между запросами, чтоб не нарваться на блокировку
    if ( $i > 0 && $i < count( $basic_keywords_array ) - 1 ) {
        sleep( 1 );
    };
};


//двумерность массивов подсказок делаем одномерной
if ( isset( $hint_keyword_array ) ) {
    $hint_keyword_array = call_user_func_array( 'array_merge', $hint_keyword_array );
};
if ( isset( $hint_keyword_array_full ) ) {
    $hint_keyword_array_full = call_user_func_array( 'array_merge', $hint_keyword_array_full );
};


//делаем единый массив обрезанных и необрезанных подсказок, если оба исходника существуют
if ( isset( $hint_keyword_array ) && isset ( $hint_keyword_array_full ) ) {
    $hint_keyword_array = array_merge( $hint_keyword_array, $hint_keyword_array_full );
} else if ( ! isset( $hint_keyword_array ) && isset ( $hint_keyword_array_full ) ) {
    $hint_keyword_array = $hint_keyword_array_full;
};


//добавляем в результат ОКС
for ( $i = 0; $i < count( $basic_keywords_array ); $i ++ ) {
    //удаляем пробелы на конце у ОКС, дубликаты удалятся далее
    $basic_keywords_array[ $i ] = trim( $basic_keywords_array[ $i ] );
};
if ( isset( $hint_keyword_array ) ) {
    $hint_keyword_array = array_merge( $basic_keywords_array, $hint_keyword_array );
    //удаляем пустые значения, дубликаты и обновляем индекс
    $hint_keyword_array = array_values( array_unique( ( array_diff( $hint_keyword_array, array( "" ) ) ) ) );
} else {
    $hint_keyword_array = array_values( array_unique( $basic_keywords_array ) );
};


//дополнительно добавляем в результат все слова из словосочетаний по-отдельности
$hint_individual_keyword_array = implode( " ", $hint_keyword_array );
$hint_individual_keyword_array = explode( " ", $hint_individual_keyword_array );
$hint_keyword_array            = array_values( array_unique( array_merge( $hint_keyword_array, $hint_individual_keyword_array ) ) );


//добавление перевода
for ( $i = 0; $i < count( $hint_keyword_array ); $i ++ ) {
    $result_array [ $i ] = [
        $result = [
            "hint"        => $hint_keyword_array[ $i ],
            "translation" => SELECT_TRANSLATION( $hint_keyword_array[ $i ], $db_connect )
        ]
    ];
};


//подготовка json-ответа
$json_result = json_encode($result_array, JSON_UNESCAPED_UNICODE);


echo( $json_result );


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// ФУНКЦИИ /////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


//готовит для запросов массив ОКС из строки ОКС
function PREPARE_BASIC_KEYWORDS_ARRAY( $_PARAM_basic_keywords_string ) {
    $basic_keywords_array = mb_strtolower( htmlspecialchars( strip_tags( stripslashes( $_PARAM_basic_keywords_string ) ) ), "utf-8" );
    $basic_keywords_array = preg_replace( "/ {2,}/", " ", $basic_keywords_array );
    $basic_keywords_array = preg_split( "[\n|,|;]", $basic_keywords_array, - 1, PREG_SPLIT_NO_EMPTY );
    for ( $i = 0; $i < count( $basic_keywords_array ); $i ++ ) {
        $basic_keywords_array[ $i ] = trim( $basic_keywords_array[ $i ] );
    };
    $basic_keywords_array = array_values( array_unique( ( array_diff( $basic_keywords_array, array( "" ) ) ) ) );
    if ( count( $basic_keywords_array ) == 0 ) {
        $basic_keywords_array = [ "" ];
    } else {
        for ( $i = 0; $i < count( $basic_keywords_array ); $i ++ ) {
            //создаём дополнительный массив ОКС с пробелами на конце, чтобы искать и по отдельному слову
            $basic_keywords_array_endspase[ $i ] = $basic_keywords_array[ $i ] . " ";
        };
        $basic_keywords_array = array_merge( $basic_keywords_array, $basic_keywords_array_endspase );
    };

    return $basic_keywords_array;
}

;


//создаёт json-ответ для одного ОКС
function JSON_RESPONCE_FOR_ONE_BASIC_KEYWORD( $_PARAM_basic_keyword, $_PARAM_media_type ) {
    if ( $_PARAM_basic_keyword != "" ) {
        $_PARAM_basic_keyword = preg_replace( "/ /", "+", $_PARAM_basic_keyword );
    };
    $anticache_time = time();
    $anticache_num  = rand( 100, 999 );
    $anticache_id   = $anticache_time . $anticache_num;
    $url            = "https://www.shutterstock.com/api/autocomplete?q=" . $_PARAM_basic_keyword . "&mediaType=" . $_PARAM_media_type . "&_=" . $anticache_id;
    $sesion         = curl_init();
    curl_setopt( $sesion, CURLOPT_URL, $url );
    curl_setopt( $sesion, CURLOPT_RETURNTRANSFER, true );
    $json_responce = curl_exec( $sesion );
    curl_close( $sesion );

    return $json_responce;
}

;


//очищает от служебной информации массив подсказок для одного json-ответа
function CLEANING_FOR_ONE_JSON_RESPONCE( $_PARAM_json_responce ) {
    $clean_json_responce_array = json_decode( $_PARAM_json_responce, true );
    $clean_json_responce_array = $clean_json_responce_array["data"]["autocompletions"];

    return $clean_json_responce_array;
}

;


//удаляет ОКС из подсказки
function DELETE_BASIC_KEYWORD_FROM_HINT( $_PARAM_basic_keyword, $_PARAM_hint ) {
    $pattern_for_delete = $_PARAM_basic_keyword . " ";
    if ( mb_strpos( $_PARAM_hint, $pattern_for_delete ) === 0 ) {
        $hint_keyword = mb_strcut( $_PARAM_hint, mb_strlen( $pattern_for_delete ) );
    } else {
        $hint_keyword = $_PARAM_hint;
    };

    return $hint_keyword;
}

;


//выбирает перевод
function SELECT_TRANSLATION( $_PARAM_hint_keyword, $_PARAM_db_connect ) {
    $_SQL_select_translations = "SELECT
    `tz`.`z`
FROM
    `tz`
        JOIN
    `k_l` ON `tz`.`idz` = `k_l`.`idz`
        JOIN
    `l-ts` ON `k_l`.`idl` = `l-ts`.`ids`
WHERE
    `l-ts`.`s` = '" . $_PARAM_hint_keyword . "'
    ";
    $_SQL_translations        = mysqli_query( $_PARAM_db_connect, $_SQL_select_translations );
    $n                        = 0;
    while ( $data = mysqli_fetch_array( $_SQL_translations ) ) {
        $translations_array[ $n ] = $data['z'];
        $n ++;
    };
    if ( count( $translations_array ) == 0 ) {
        $translations_array[0] = "Перевода нет.";
    };

    return $translations_array;
}

;