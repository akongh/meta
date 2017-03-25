<?php error_reporting( - 1 );
session_start();
include( $_SERVER['DOCUMENT_ROOT'] . '/meta_config_db.php' );
include( $_SERVER['DOCUMENT_ROOT'] . '/meta_config.php' );

$slovo_k = $_SESSION["slovo_original"];

mysqli_query( $db_connect, "
UPDATE `k-ts`
SET `f` = 5
WHERE `s` = '" . $slovo_k . "' 
" );

mysqli_close( $db_connect );
header( "Location: http://" . $site_domain_name . "/meta_admin/translation_frequency.php" );