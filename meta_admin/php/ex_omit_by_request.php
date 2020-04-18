<?php error_reporting( - 1 );
session_start();
include( $_SERVER['DOCUMENT_ROOT'] . '/meta_config_db.php' );

$slovo_k = $_SESSION["slovo_original"];

mysqli_query( $mysqli, "
UPDATE `k-ts`
SET `f` = 5
WHERE `s` = '" . $slovo_k . "' 
" );

mysqli_close( $mysqli );
header( "Location: //" . $_SERVER["HTTP_HOST"] . "/meta_admin/translation_request.php" );