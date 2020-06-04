<?php

declare(strict_types=1);
error_reporting(-1);

//получаем и определяем добавляемые ключевые слова
$basic_keywords_string = $_POST["basicKeywordsString"];

//готовим для поиска переводов массив добавляемых ключевых слов
$basic_keywords_array = PREPARE_ADD_TO_LIST_KEYWORDS_ARRAY( $basic_keywords_string );

//проверка колличества добавляемых ключевых слов
if ( count( $basic_keywords_array ) > 2000 ) {
    echo( "-1" );
    exit;
}

//добавление перевода
require($_SERVER["DOCUMENT_ROOT"] . '/_privacy_path.php');
for ( $i = 0; $i < count( $basic_keywords_array ); $i ++ ) {
    $result_array [ $i ] = [
        "hint"        => $basic_keywords_array[ $i ],
        "translation" => SELECT_TRANSLATION( $basic_keywords_array[ $i ], $mysqli )
    ];
}
mysqli_close( $mysqli );

//подготовка json-ответа
$json_result = json_encode( $result_array, JSON_UNESCAPED_UNICODE );

echo( $json_result );

/**
 * Functions.
 */

//готовит для поиска переводов массив добавляемых ключевых слов
function PREPARE_ADD_TO_LIST_KEYWORDS_ARRAY( $_PARAM_basic_keywords_string ) {
    $basic_keywords_array = mb_strtolower( htmlspecialchars( strip_tags( stripslashes( $_PARAM_basic_keywords_string ) ) ), "utf-8" );
    $basic_keywords_array = preg_replace(["/ {2,}/", "/&amp;/"], [" ", "&"], $basic_keywords_array);
    $basic_keywords_array = preg_split( "/[\n,;]/", $basic_keywords_array, - 1, PREG_SPLIT_NO_EMPTY );

    for ( $i = 0; $i < count( $basic_keywords_array ); $i ++ ) {
        $basic_keywords_array[ $i ] = preg_replace("/&/", "&amp;", trim( $basic_keywords_array[ $i ] ));
    }
    $basic_keywords_array = array_values( array_unique( ( array_diff( $basic_keywords_array, array( "" ) ) ) ) );
    //только латиница, цифры, пробел, дефис, апостроф и амперсанд//TODO: и амперсант
//    for ( $i = 0; $i < count( $basic_keywords_array ); $i ++ ) {
//        if ( ! preg_match( "/^([a-z0-9\s\-\'(&amp;)]+)$/iu", $basic_keywords_array[ $i ] ) ) {
//            echo( "-2" );
//            exit;
//        }
//    }

    return $basic_keywords_array;
}

//выбирает перевод для одного слова
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
