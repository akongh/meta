<?php error_reporting( - 1 );

//получаем и определяем строку ОКС
$basic_keywords_string = $_POST["basicKeywordsString"];

//готовим для запросов массив ОКС из строки ОКС
$basic_keywords_array = PREPARE_BASIC_KEYWORDS_ARRAY( $basic_keywords_string );

//проверка на непустой запрос
if ( $basic_keywords_array == [ "" ] ) {
    echo( "-3" );
    exit;
}

//проверка колличества ОКС
if ( count( $basic_keywords_array ) > 16 ) {
    echo( "-1" );
    exit;
}

//подстроки для правила удаления ОКС из подсказки
require( $_SERVER["DOCUMENT_ROOT"] . '/hints/php/rules.php' );

//получаем json-ответы для каждого ОКС
for ( $i = 0; $i < count( $basic_keywords_array ); $i ++ ) {
    $json_responce_array[ $i ] = JSON_RESPONCE_FOR_ONE_BASIC_KEYWORD( $basic_keywords_array[ $i ] );

    //очистка json-ответа от имени функции-обёртки
    $clean_json_responce_array[ $i ] = CLEANING_FOR_ONE_JSON_RESPONCE( $json_responce_array[ $i ], $basic_keywords_array[ $i ] );

    //поднимаем на один уроввень мерность
    for ( $j = 0; $j < count( $clean_json_responce_array[ $i ] ); $j ++ ) {

        //на всякий случай чистим края
        $only_pattern_array[ $i ][ $j ] = trim( $clean_json_responce_array[ $i ][ $j ]["DisplayText"] );

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
        }
        if ( $f === true ) {
            $hint_keyword_array[ $i ][ $j ] = DELETE_BASIC_KEYWORD_FROM_HINT( $current_keyword, $current_pattern );
        } else {
            $hint_keyword_array[ $i ][ $j ] = $current_pattern;
        }
        $hint_keyword_array_full[ $i ][ $j ] = $current_pattern;
    }

    //спим между запросами, чтоб не нарваться на блокировку
    if ( $i > 0 && $i < count( $basic_keywords_array ) - 1 ) {
        usleep( 400000 );
    }
}

//двумерность массивов подсказок делаем одномерной
if ( isset( $hint_keyword_array ) ) {
    $hint_keyword_array = call_user_func_array( 'array_merge', $hint_keyword_array );
}
if ( isset( $hint_keyword_array_full ) ) {
    $hint_keyword_array_full = call_user_func_array( 'array_merge', $hint_keyword_array_full );
}

//делаем единый массив обрезанных и необрезанных подсказок, если оба исходника существуют
if ( isset( $hint_keyword_array ) && isset ( $hint_keyword_array_full ) ) {
    $hint_keyword_array = array_merge( $hint_keyword_array, $hint_keyword_array_full );
} else if ( ! isset( $hint_keyword_array ) && isset ( $hint_keyword_array_full ) ) {
    $hint_keyword_array = $hint_keyword_array_full;
}

//добавляем в результат ОКС
for ( $i = 0; $i < count( $basic_keywords_array ); $i ++ ) {
    //удаляем пробелы на конце у ОКС, уравниваем код амперсанда, дубликаты удалятся далее
    $basic_keywords_array[ $i ] = preg_replace("/%26/", "&", trim( $basic_keywords_array[ $i ] ));
}
if ( isset( $hint_keyword_array ) ) {
    $hint_keyword_array = array_merge( $basic_keywords_array, $hint_keyword_array );
    //удаляем пустые значения, дубликаты и обновляем индекс
    $hint_keyword_array = array_values( array_unique( ( array_diff( $hint_keyword_array, array( "" ) ) ) ) );
} else {
    $hint_keyword_array = array_values( array_unique( $basic_keywords_array ) );
}

//дополнительно добавляем в результат все слова из словосочетаний по-отдельности
$hint_individual_keyword_array = implode( " ", $hint_keyword_array );
$hint_individual_keyword_array = explode( " ", $hint_individual_keyword_array );
$hint_keyword_array            = array_values( array_unique( array_merge( $hint_keyword_array, $hint_individual_keyword_array ) ) );

//заменяем амперсанд, чтоб не ломал javscript потом
for($i = 0; $i < count($hint_keyword_array); $i++){
    $hint_keyword_array[$i] = preg_replace("/&/","&amp;",$hint_keyword_array[$i]);
}

//добавление перевода
require( $_SERVER["DOCUMENT_ROOT"] . '/meta_config_db.php' );
for ( $i = 0; $i < count( $hint_keyword_array ); $i ++ ) {
    $result_array [ $i ] = [
        "hint"        => $hint_keyword_array[ $i ],
        "translation" => SELECT_TRANSLATION( $hint_keyword_array[ $i ], $mysqli )
    ];
}
mysqli_close( $mysqli );

//подготовка json-ответа
$json_result = json_encode( $result_array, JSON_UNESCAPED_UNICODE );

echo( $json_result );

/**
 * Functions.
 */

//готовит для запросов массив ОКС из строки ОКС
function PREPARE_BASIC_KEYWORDS_ARRAY( $_PARAM_basic_keywords_string ) {
    $basic_keywords_array = mb_strtolower( htmlspecialchars( strip_tags( stripslashes( $_PARAM_basic_keywords_string ) ) ), "utf-8" );
    //заменяем код амперсанда для запроса подсказок
    $basic_keywords_array = preg_replace(["/ {2,}/", "/&amp;/"], [" ", "%26"], $basic_keywords_array);
    $basic_keywords_array = preg_split( "/[\n,;]/", $basic_keywords_array, - 1, PREG_SPLIT_NO_EMPTY );

    for ( $i = 0; $i < count( $basic_keywords_array ); $i ++ ) {
        $basic_keywords_array[ $i ] = trim( $basic_keywords_array[ $i ] );
        //только латиница, цифры, пробел, дефис, апостроф и амперсанд
//        if ( $basic_keywords_array[ $i ] != "" && ! preg_match( "/^([a-z0-9\s\-\'(%26)]+)$/iu", $basic_keywords_array[ $i ] ) ) {
//            echo( "-2" );
//            exit;
//        }
    }
    $basic_keywords_array = array_values( array_unique( ( array_diff( $basic_keywords_array, array( "" ) ) ) ) );
    if ( count( $basic_keywords_array ) == 0 ) {
        $basic_keywords_array = [ "" ];
    }

    return $basic_keywords_array;
}

//создаёт json-ответ для одного ОКС
function JSON_RESPONCE_FOR_ONE_BASIC_KEYWORD( $_PARAM_basic_keyword ) {
    if ( $_PARAM_basic_keyword != "" ) {
        $_PARAM_basic_keyword = preg_replace( "/ /", "+", $_PARAM_basic_keyword );
    }
    $url    = "http://as.gettyservices.com/GettyImages.Autocomplete.KeywordService.Service/KeywordService1/Suggestedkeywords/705/en-us/image/" . $_PARAM_basic_keyword . "/any?usePopularity=true&callback=as_cb_" . preg_replace("/%/", "_", $_PARAM_basic_keyword);
    $sesion = curl_init();
    curl_setopt( $sesion, CURLOPT_URL, $url );
    curl_setopt( $sesion, CURLOPT_RETURNTRANSFER, true );
    curl_setopt( $sesion, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/58.0.3029.97 Safari/537.36 Vivaldi/1.9.818.49' );
    $json_responce = curl_exec( $sesion );
    curl_close( $sesion );

    return $json_responce;
}

//очищает от служебной информации массив подсказок для одного json-ответа
function CLEANING_FOR_ONE_JSON_RESPONCE( $_PARAM_json_responce, $_PARAM_basic_keyword ) {
    $clean_json_responce       = preg_replace( "/ {2,}/", " ", $_PARAM_json_responce );
    $string_pattern            = '/as_cb_' . preg_replace("/%/", "_", $_PARAM_basic_keyword) . '\(/';
    $clean_json_responce       = preg_replace( $string_pattern, "", $clean_json_responce );
    $clean_json_responce       = preg_replace( "/\)/", "", $clean_json_responce );
    $clean_json_responce_array = json_decode( $clean_json_responce, true );
    $clean_json_responce_array = $clean_json_responce_array["CompletedKeywords"];

    return $clean_json_responce_array;
}

//удаляет ОКС из подсказки
function DELETE_BASIC_KEYWORD_FROM_HINT( $_PARAM_basic_keyword, $_PARAM_hint ) {
    $pattern_for_delete = $_PARAM_basic_keyword . " ";
    if ( mb_strpos( $_PARAM_hint, $pattern_for_delete ) === 0 ) {
        $hint_keyword = mb_strcut( $_PARAM_hint, mb_strlen( $pattern_for_delete ) );
    } else {
        $hint_keyword = $_PARAM_hint;
    }

    return $hint_keyword;
}

//выбирает перевод для одной подсказки
function SELECT_TRANSLATION( $_PARAM_hint_keyword, $_PARAM_db_connect ) {
    $_PARAM_hint_keyword = preg_replace("/&amp;/", "&", $_PARAM_hint_keyword);
    $_SQL_select_translations = "SELECT
    `tz`.`z`
FROM
    `tz`
        JOIN
    `k_l` ON `tz`.`idz` = `k_l`.`idz`
        JOIN
    `l-ts` ON `k_l`.`idl` = `l-ts`.`ids`
WHERE
    `l-ts`.`s` = '" . preg_replace("/'/", "\'", $_PARAM_hint_keyword) . "';
    ";
    $_SQL_translations        = mysqli_query( $_PARAM_db_connect, $_SQL_select_translations );
    $n                        = 0;
    while ( $data = mysqli_fetch_array( $_SQL_translations ) ) {
        $translations_array[ $n ] = $data["z"];
        $n ++;
    }
    if ( ! isset( $translations_array ) || count( $translations_array ) == 0 ) {
        $translations_array[0] = "-";
    }

    return $translations_array;
}
