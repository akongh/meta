<?php error_reporting( - 1 );

//Задаём переменные
if ( isset( $_POST["kwString"] ) && ! preg_match( "/^([а-яё]+)$/iu", $_POST["kwString"] ) ) {//проверка на отсутствие кирилицы
    $kw = preg_replace( "/ {2,}/", " ", trim( $_POST["kwString"] ) );//убираем крайние и двойные пробелы
} else {
    $kw = "";
};
$kw_query = preg_replace( "/ /", "+", $kw );//заменяем пробелы на «+» для строки запроса
if ( isset( $_POST["mtRadio"] ) ) {
    $mt = $_POST["mtRadio"];
} else {
    $mt = "image";
};
$fake_time = time() - rand( 14400, 43200 );
$fake_num  = rand( 100, 999 );
$id        = $fake_time . $fake_num;//TODO: Пока тупая имитация, выяснить истинное формирование этого значения. Похоже, оно нужно для статистики или для отслеживания автозапросов. Пока не перезагрузишь страницу, часть с временем не меняется, а добавка растёт на единицу при каждом запросе.
//TODO: Возможно, имеет смысл попытаться подменить другие данные (о клиенте и т. д.), которые передаются или наоборот, добавить, чтоб не было видно, что запросы с сервера.
$url           = "https://www.shutterstock.com/api/autocomplete?q=" . $kw_query . "&mediaType=" . $mt . "&_=" . $id;
$fake_time_num = $fake_time . " - [ " . date( 'd.m.Y, H:i:s', $fake_time ) . " ] - " . $fake_num;

//Запрос-ответ
$ses = curl_init();
curl_setopt( $ses, CURLOPT_URL, $url );
curl_setopt( $ses, CURLOPT_RETURNTRANSFER, true );
$data = curl_exec( $ses );
curl_close( $ses );

//Форматирование json-ответа
$format_data = json_decode( $data, true );
$format_data = $format_data["data"]["autocompletions"];

//Создание массива строк «ключ-значение»
//for ( $i = 0; $i < count( $format_data ); $i ++ ) {
//    $format_data_arr[ $i ] = "<tr><td class='table-sqs-patterns'><span id='pattern-kw' class='bold kw-pattern'>" . trim( str_replace( trim($kw) . " ", "", $format_data[ $i ]["pattern"] ) ) . "</span></td><td>" . $format_data[ $i ]["probability"] . "</td></tr>\n";
//}
////Создание строки «ключ-значение»
//if ( isset( $format_data_arr ) ) {
//    $format_data_string = "<table class='table-sqs'>\n" . implode( "", $format_data_arr ) . "</table>";
//}

for ( $i = 0; $i < count( $format_data ); $i ++ ) {
    $format_data_arr[ $i ] = trim( str_replace( trim( $kw ) . " ", "", $format_data[ $i ]["pattern"] ) ) . " - " . $format_data[ $i ]["probability"];
}
if ( isset( $format_data_arr ) ) {
    $format_data_str = implode( ", ", $format_data_arr );
} else {
    $format_data_str = "Нет подсказок.";
}

echo( $format_data_str );