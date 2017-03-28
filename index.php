<?php error_reporting( - 1 );
session_start();
session_unset();
unset( $_POST );
include( $_SERVER['DOCUMENT_ROOT'] . '/meta_config_db.php' );
include( $_SERVER['DOCUMENT_ROOT'] . '/meta_config.php' );

$SQL_count_translated_words_query = mysqli_query( $db_connect, "
	select count(`k-ts`.`s`)
	from `k-ts`
	where `f` = 1
	" );

$data                       = mysqli_fetch_array( $SQL_count_translated_words_query );
$SQL_count_translated_words = number_format( $data[0], 0, '', ' ' );

include( 'html/meta.html' );