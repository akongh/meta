<?php
/**
 * Created by PhpStorm.
 * User: Andrei
 * Date: 18.04.2017
 * Time: 22:11
 */

$kw = "pattern";

$fake_time = time() - rand( 14400, 43200 );
$id        = $fake_time . rand( 100, 999 );//TODO: Пока тупая имитация, выяснить истинное формирование этого значения. Похоже, оно нужно для статистики или для отслеживания автозапросов. Пока не перезагрузишь страницу, часть с временем не меняется, а добавка растёт на единицу при каждом запросе.
//TODO: Можно ещё от части со временем отнимать или прибавлять несколько часов для скрытия времени сервера. Если только истинное время больше никак не передаётся.
//TODO: Возможно, имеет смысл попытаться подменить другие данные (о клиенте и т. д.), которые передаются или наоборот, добавить, чтоб не было видно, что запросы с сервера.
$url = "https://www.shutterstock.com/api/autocomplete?q=" . $kw . "&mediaType=image&_=" . $id;

$ses = curl_init();
curl_setopt( $ses, CURLOPT_URL, $url );
curl_setopt( $ses, CURLOPT_RETURNTRANSFER, true );
$data = curl_exec( $ses );

print_r( "<pre>" );
print_r( json_decode( $data, true ) );
print_r( "</pre>" );


echo( "<br>" );
echo( "<br>" );
echo date( 'd m Y _ H:i:s', $fake_time );
echo( "<br>" );
echo( "<br>" );
echo( $id );


curl_close( $ses );