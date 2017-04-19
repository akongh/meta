<?php
/**
 * Created by PhpStorm.
 * User: Andrei
 * Date: 18.04.2017
 * Time: 22:11
 */

$kw        = "icon";
$fake_time = time() - rand( 14400, 43200 );
$fake_num  = rand( 100, 999 );
$id        = $fake_time . $fake_num;//TODO: Пока тупая имитация, выяснить истинное формирование этого значения. Похоже, оно нужно для статистики или для отслеживания автозапросов. Пока не перезагрузишь страницу, часть с временем не меняется, а добавка растёт на единицу при каждом запросе.
//TODO: Можно ещё от части со временем отнимать или прибавлять несколько часов для скрытия времени сервера. Если только истинное время больше никак не передаётся.
//TODO: Возможно, имеет смысл попытаться подменить другие данные (о клиенте и т. д.), которые передаются или наоборот, добавить, чтоб не было видно, что запросы с сервера.
$url = "https://www.shutterstock.com/api/autocomplete?q=" . $kw . "&mediaType=image&_=" . $id;

print_r( "<pre>" );

echo( $kw );
echo( "<br>" );
echo( "<br>" );
echo( $fake_time . " - [ " . date( 'd.m.Y, H:i:s', $fake_time ) . " ] - " . $fake_num );
echo( "<br>" );
echo( "<br>" );

$ses = curl_init();
curl_setopt( $ses, CURLOPT_URL, $url );
curl_setopt( $ses, CURLOPT_RETURNTRANSFER, true );
$data = curl_exec( $ses );
curl_close( $ses );

$format_data = json_decode( $data, true );
$format_data = $format_data["data"];
$format_data = $format_data["autocompletions"];

for ( $i = 0; $i < count( $format_data ); $i ++ ) {
    echo( $format_data[ $i ]["pattern"] . " - " . $format_data[ $i ]["probability"] . "<br>" );
}

print_r( "</pre>" );