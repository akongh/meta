<?php error_reporting( - 1 );
include( $_SERVER['DOCUMENT_ROOT'] . '/meta_config_db.php' );
$nomer_straniczy_zapros = mysqli_query( $db_connect, "SELECT `lori` FROM `tyrki` WHERE `f` = 1" );
$nomer_straniczy_otvet  = mysqli_fetch_row( $nomer_straniczy_zapros );
$nomer_straniczy        = $nomer_straniczy_otvet[0] + 1;
$nomer_straniczy_2      = $nomer_straniczy + 999;
include( 'tyrka_lori.html' );