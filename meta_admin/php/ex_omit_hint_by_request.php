<?php error_reporting( - 1 );
session_start();
include( $_SERVER['DOCUMENT_ROOT'] . '/meta_config_db.php' );

$kw_ru = $_SESSION["original_kw"];

mysqli_query( $mysqli, "
UPDATE `l-ts`
SET `f` = 5
WHERE `s` = '" . $kw_ru . "' 
" );

mysqli_close( $mysqli );
header( "Location: //" . $_SERVER["HTTP_HOST"] . "/meta_admin/translation_hint.php" );