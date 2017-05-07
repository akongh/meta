<?php error_reporting( - 1 );

$kir_kol_slov_zapros     = mysqli_query( $db_connect, "SELECT COUNT(*) FROM `k-ts`" );
$kir_kol_naborov_zapros  = mysqli_query( $db_connect, "SELECT COUNT(*) FROM `k-tn`" );
$lat_kol_slov_zapros     = mysqli_query( $db_connect, "SELECT COUNT(*) FROM `l-ts`" );
$na_zayavke_zapros       = mysqli_query( $db_connect, "SELECT COUNT(*) FROM `k-ts` WHERE `f` = '7'" );
$perevedeno_zapros       = mysqli_query( $db_connect, "SELECT COUNT(*) FROM `k-ts` WHERE `f` = '1'" );
$hint_translation_querry = mysqli_query( $db_connect, "SELECT COUNT(*) FROM `l-ts` WHERE `f` = '1'" );
$hint_request_querry     = mysqli_query( $db_connect, "SELECT COUNT(*) FROM `l-ts` WHERE `f` = '7'" );