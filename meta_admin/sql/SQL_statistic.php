<?php

$amount_ru_kws_zapros     = mysqli_query( $mysqli, "SELECT COUNT(*) FROM `k-ts`" );
$amount_ru_kws_set_zapros  = mysqli_query( $mysqli, "SELECT COUNT(*) FROM `k-tn`" );
$amount_en_kws_zapros     = mysqli_query( $mysqli, "SELECT COUNT(*) FROM `l-ts`" );
$na_zayavke_zapros       = mysqli_query( $mysqli, "SELECT COUNT(*) FROM `k-ts` WHERE `f` = '7'" );
$perevedeno_zapros       = mysqli_query( $mysqli, "SELECT COUNT(*) FROM `k-ts` WHERE `f` = '1'" );
$hint_translation_querry = mysqli_query( $mysqli, "SELECT COUNT(*) FROM `l-ts` WHERE `f` = '1'" );
$hint_request_querry     = mysqli_query( $mysqli, "SELECT COUNT(*) FROM `l-ts` WHERE `f` = '7'" );