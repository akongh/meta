<?php error_reporting( - 1 );

//получаем и определяем ОКС на русском языке для перевода
$keyword_in_russian = $_POST["keywordInRussian"];

//готовим ОКС на русском для зопроса переводов
$keyword_in_russian = PREPARE_KEYWORD_IN_RUSSIAN_FOR_TRANLATION( $keyword_in_russian );

//нечего переводить
if ( $keyword_in_russian == "" ) {
    echo( "-2" );
    exit;
}

//только кирилица, цифры, пробел и дефис
if ( ! preg_match( "/^[а-яё0-9 \-]+$/iu", $keyword_in_russian ) ) {
    echo( "-3" );
    exit;
}

//попытка найти для полученного ОКС переводы
require($_SERVER["DOCUMENT_ROOT"] . '/_privacy_path.php');
$translations_array = SEARCH_TRANLATIONS( $mysqli, $keyword_in_russian );
mysqli_close( $mysqli );

//перевод не найден
if ( $translations_array == "-1" ) {
    echo( "-1" );
    exit;
}

//подготовка json-ответа
$json_result = json_encode( $translations_array, JSON_UNESCAPED_UNICODE );

echo $json_result;

/**
 * Functions.
 */

//проверяет, чистит и правит полученное ОКС
function PREPARE_KEYWORD_IN_RUSSIAN_FOR_TRANLATION( $PARAM_keyword_in_russian ) {
    $keyword_in_russian = mb_strtolower( htmlspecialchars( strip_tags( stripslashes( $PARAM_keyword_in_russian ) ) ), "utf-8" );
    $keyword_in_russian = trim( preg_replace( "/ {2,}/", " ", $keyword_in_russian ) );

    return $keyword_in_russian;
}

//ищет в базе переводы
function SEARCH_TRANLATIONS( $PARAM_db_connect, $PARAM_keyword_in_russian ) {

    $SQL_select_translations_and_sense = mysqli_query( $PARAM_db_connect, "
	select `l-ts`.`s`, `tz`.`z`
	from `k-ts`
	join `k_l` on `k-ts`.`ids`=`k_l`.`idk`
	join `l-ts` on `l-ts`.`ids`=`k_l`.`idl`
	join `tz` on `tz`.`idz`=`k_l`.`idz`
	where `k-ts`.`s`='" . $PARAM_keyword_in_russian . "'
	" );

    $n = 0;
    while ( $result = mysqli_fetch_array( $SQL_select_translations_and_sense ) ) {
        $translation[ $n ]        = $result["s"];
        $sense[ $n ]              = $result["z"];
        $translations_array[ $n ] = "
        <span class='hover-invert'>" . $translation[ $n ] . "</span> - " . $sense[ $n ] . "<br>
        ";
        $n ++;
    }

    if ( isset( $translations_array ) && count( $translations_array ) > 0 ) {
        return $translations_array;
    } else {
        return "-1";
    }
}
