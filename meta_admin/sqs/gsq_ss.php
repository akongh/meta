<?php
/**
 * Created by PhpStorm.
 * User: Andrei
 * Date: 18.04.2017
 * Time: 22:11
 */

$kw  = "news";
$url = "https://www.shutterstock.com/api/autocomplete?q=" . $kw . "+&mediaType=image&_=1492495477024";
$ses = curl_init();
curl_setopt( $ses, CURLOPT_URL, $url );
curl_setopt( $ses, CURLOPT_RETURNTRANSFER, true );
echo $data = curl_exec( $ses );
curl_close( $ses );