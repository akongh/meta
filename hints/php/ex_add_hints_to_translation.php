<?php error_reporting( - 1 );


$json_hints_string_for_translation = $_POST["jsonHintsStringForTranlation"];
$json_hints_array_for_translation  = json_decode( $json_hints_string_for_translation, JSON_UNESCAPED_UNICODE );

include( $_SERVER['DOCUMENT_ROOT'] . '/meta_config_db.php' );
for ( $i = 0; $i < count($json_hints_array_for_translation); $i ++ ) {

    mysqli_query( $db_connect, "
	INSERT IGNORE INTO `l-ts` (`s`)
	VALUES ('" . $json_hints_array_for_translation[ $i ] . "')
    " );

    mysqli_query( $db_connect, "
	UPDATE `l-ts`
	SET `f` = 7
	WHERE `s` = '" . $json_hints_array_for_translation[ $i ] . "' and `f` = 0
    " );

};
mysqli_close( $db_connect );