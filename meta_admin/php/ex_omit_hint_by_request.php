<?php error_reporting( - 1 );
session_start();
include( $_SERVER['DOCUMENT_ROOT'] . '/meta_config_db.php' );

$slovo_k = $_SESSION["slovo_original"];

mysqli_query( $db_connect, "
UPDATE `l-ts`
SET `f` = 5
WHERE `s` = '" . $slovo_k . "' 
" );

mysqli_close( $db_connect );
header( "Location: //" . $_SERVER["HTTP_HOST"] . "/meta_admin/translation_hint.php" );