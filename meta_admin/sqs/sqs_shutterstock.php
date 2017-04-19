<?php error_reporting( - 1 );
/**
 * Created by PhpStorm.
 * User: Andrei
 * Date: 18.04.2017
 * Time: 22:11
 */

//Задаём переменные
if ( isset( $_POST["kw"] ) && ! preg_match( "/^([а-яё\s\-]+)$/iu", $_POST["kw"] ) ) {//проверка на отсутствие кирилицы
    $kw = $_POST["kw"];
} else {
    $kw = "";
};
$kw = preg_replace( "/ /", "+", $kw );//заменяем пробелы на «+» для строки запроса
if ( isset( $_POST["mt"] ) ) {
    $mt = $_POST["mt"];
} else {
    $mt = "image";
};
$fake_time = time() - rand( 14400, 43200 );
$fake_num  = rand( 100, 999 );
$id        = $fake_time . $fake_num;//TODO: Пока тупая имитация, выяснить истинное формирование этого значения. Похоже, оно нужно для статистики или для отслеживания автозапросов. Пока не перезагрузишь страницу, часть с временем не меняется, а добавка растёт на единицу при каждом запросе.
//TODO: Возможно, имеет смысл попытаться подменить другие данные (о клиенте и т. д.), которые передаются или наоборот, добавить, чтоб не было видно, что запросы с сервера.
$url           = "https://www.shutterstock.com/api/autocomplete?q=" . $kw . "&mediaType=" . $mt . "&_=" . $id;
$fake_time_num = $fake_time . " - [ " . date( 'd.m.Y, H:i:s', $fake_time ) . " ] - " . $fake_num;

//Запрос-ответ
$ses = curl_init();
curl_setopt( $ses, CURLOPT_URL, $url );
curl_setopt( $ses, CURLOPT_RETURNTRANSFER, true );
$data = curl_exec( $ses );
curl_close( $ses );

//Форматирование json-ответа
$format_data = json_decode( $data, true );
$format_data = $format_data["data"];
$format_data = $format_data["autocompletions"];

//Создание массива строк «ключ-значение»
for ( $i = 0; $i < count( $format_data ); $i ++ ) {
    $format_data_arr[ $i ] = "<tr><td class='table-sqs-patterns'><span name='pattern-kw' class='bold kw-pattern'>" . $format_data[ $i ]["pattern"] . "</span></td><td>" . $format_data[ $i ]["probability"] . "</td></tr>\n";
}
//Создание строки «ключ-значение»
if ( isset( $format_data_arr ) ) {
    $format_data_string = "<table class='table-sqs'>\n" . implode( "", $format_data_arr ) . "</table>";
}

//Возвращаем пробелы после использования в запросе
//$kw = preg_replace( "/\+/", " ", $kw );

include( 'sqs.html' );